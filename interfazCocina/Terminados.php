<?php
include 'conexion/cone.php';

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    try {
        if ($accion == 'limpiar') {
            $cone->beginTransaction();

            // Mover los registros a historial_pedido
            $stmt = $cone->prepare("
                INSERT INTO historial_pedido (pedido_idPedido, estados_idStatus, Fecha, FechaAprobacion,
                Cliente_idCliente, mesa_idMesa, usuario_idUsuario, tipopedido_idTipoPedido,
                mediopago_idMedioPago, fechaCocinando, fechaTerminado)
                SELECT idPedido, Estado, Fecha, FechaAprobacion, Cliente_idCliente, Mesa_id, Usuario_id, TipoPedido_id, MedioPago_id, fechaCocinando, fechaTerminado
                FROM pedido
                WHERE Estado = 4
            ");
            if ($stmt->execute()) {
                // Obtener los IDs de los pedidos movidos
                $movedIds = $cone->query("SELECT idPedido FROM pedido WHERE Estado = 4")->fetchAll(PDO::FETCH_COLUMN);

                if (!empty($movedIds)) {
                    $idsPlaceholder = implode(',', array_fill(0, count($movedIds), '?'));

                    // Actualizar detallepedido para referirse a historial_pedido
                    $stmt_update = $cone->prepare("
                        UPDATE detallepedido dp
                        JOIN historial_pedido hp ON dp.Pedido_id = hp.pedido_idPedido
                        SET dp.Pedido_id = hp.pedido_idPedido
                        WHERE dp.Pedido_id IN ($idsPlaceholder)
                    ");
                    if ($stmt_update->execute($movedIds)) {
                        // Eliminar los pedidos terminados de la tabla principal
                        $stmt_delete = $cone->prepare("DELETE FROM pedido WHERE idPedido IN ($idsPlaceholder)");
                        if ($stmt_delete->execute($movedIds)) {
                            $cone->commit();
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        } else {
                            $cone->rollBack();
                            echo "Error al intentar eliminar de pedidos.";
                        }
                    } else {
                        $cone->rollBack();
                        echo "Error al actualizar detallepedido.";
                    }
                } else {
                    $cone->rollBack();
                    echo "No hay pedidos para mover.";
                }
            } else {
                $cone->rollBack();
                echo "Error al mover los datos a la tabla de historial.";
            }
        }
    } catch (PDOException $e) {
        if ($cone->inTransaction()) {
            $cone->rollBack();
        }
        echo "Error: " . $e->getMessage();
    }
}


    function mostrarPedidosTerminados($cone, $fecha = NULL){
        try {
            $query = "
                SELECT 
                p.idPedido,
                DATE_FORMAT(p.Fecha, '%Y-%m-%d') AS Fecha_Pedido,
                m.NumMesa AS Numero_Mesa,
                tp.TipoPed AS Tipo_Pedido,
                GROUP_CONCAT(CONCAT('▸ ', dp.Cantidad, ' ', pr.Nombre, IF(dp.NotaPedido IS NOT NULL AND dp.NotaPedido != '', 
                CONCAT(' <span style=\"color:#FF0000\">(', dp.NotaPedido, ')</span> '), '') ) SEPARATOR '\n') AS Productos,
                SUM(dp.Cantidad * pr.Precio) AS Total,
                e.nombre AS Estado_Pedido
                FROM 
                    pedido p
                JOIN 
                    mesa m ON p.Mesa_id = m.idMesa
                JOIN 
                    detallepedido dp ON p.idPedido = dp.Pedido_id
                JOIN 
                    producto pr ON dp.Producto_id = pr.idProducto
                JOIN 
                    tipopedido tp ON p.TipoPedido_id = tp.idTipoPedido
                JOIN 
                    estados e ON p.Estado = e.idStatus
                WHERE
                    p.Estado = 4
                
            ";

            if($fecha){
                $query .= " AND DATE(p.Fecha) = :fecha";
            }

            $query .="
                GROUP BY 
                    p.idPedido
                ORDER BY p.fechaTerminado ASC;
            ";

            $stmt = $cone->prepare($query);
    
            if ($fecha) {
                $stmt->bindParam(':fecha', $fecha);
            }
    
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $row) {
                $productos = nl2br($row['Productos']);
                echo "<tr>";
                echo "<td>" . $row['Fecha_Pedido'] . "</td>";
                echo "<td>" . $row['Numero_Mesa'] . "</td>";
                echo "<td>" . $row['Tipo_Pedido'] . "</td>";
                echo "<td class='texto_productos'>" . $productos . "</td>";
                echo "<td>" . $row['Total'] . "</td>";
                echo "<td>" . $row['Estado_Pedido'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<title>Tabla de Pedidos Aprobados</title>";
    echo "<link rel='stylesheet' type='text/css' href='styles.css'>";
    echo "<link rel='stylesheet' type='text/css' href='styles2.css'>";
    echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>";
    echo "</head>";
    echo "<body>";
    echo '<div class="principal ">';
    echo '<div class="sidebar-container">';
     include 'sidebar_terminado.php';
     
    echo '</div>';
    
    echo "<div class='container'>";
    

    echo "<form method='post'>";
    echo "<button type='submit' name='accion' value='limpiar'>Limpiar Tabla</button>";
    echo "<button type='submit' name='accion' value='mostrar'>Mostrar Pedidos Terminados</button>";

    echo "<label for='fecha'>  Fecha:</label>";
    echo "<input type='date' id='fecha' name='fecha'>";
    echo "<button type='submit'>Filtrar por Fecha</button>";
    echo "</form>";


    echo "<table id='table_pedidos'>";
    echo '<caption>Lista Pedidos Terminados</caption>';
    echo "<tr><th>Fecha Pedido</th><th>Numero Mesa</th><th>Tipo Pedido</th><th>Productos</th><th>Total</th><th>Estado Pedido</th></tr>";
        if (!isset($_POST['accion']) || $_POST['accion'] == 'mostrar') {
            $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
            mostrarPedidosTerminados($cone);
        }
    
    
    echo "</div>";
    echo "</div>";
    echo "</body>";
    echo "</html>";

    

    // Cerrar la conexión
    $cone = null;
?>

