<?php
    include 'conexion/cone.php';

    if (isset($_GET['pedido_id'])){
        
        $pedido_id = $_GET['pedido_id'];
        if(isset($_GET['Mesa_id'])){
            $mesa_id =$_GET['Mesa_id'];
        }
        

        try{
            $stmt = $cone ->prepare("
            SELECT 
                p.idPedido,
                dp.Cantidad,
                pr.Nombre AS Producto,
                pr.Precio AS Precio_Unitario,
                 if(dp.NotaPedido is not null and dp.NotaPedido != '',dp.NotaPedido,'No presenta') as 'Nota del Pedido'
            FROM 
                pedido p
            JOIN 
                detallepedido dp ON p.idPedido = dp.Pedido_id
            JOIN 
                producto pr ON dp.Producto_id = pr.idProducto
            WHERE
                p.idPedido = :pedido_id

        "
        );

        // Asociar el parámetro del ID del pedido
        $stmt->bindParam(':pedido_id', $pedido_id);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        
            if($result){
                echo "<!DOCTYPE html>";
                echo "<html>";
                echo "<head>";
                echo "<title>Tabla de editar</title>";
                echo "<link rel='stylesheet' type='text/css' href='styles.css'>";
                echo "<link rel='stylesheet' type='text/css' href='styles2.css'>";
                echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>";
                echo "</head>";
                echo "<body>";
                echo '<div class="principal ">';
                echo '<div class="sidebar-container">';
                    include 'sidebar_pendiente.php';
                echo '</div>';
    
                echo "<div class='container'>";
                echo "<table id='table_pedidos'>";

                echo '<caption>Detalle del pedido </caption>';
                echo "<h2>PEDIDO DE LA MESA: " . $mesa_id . "</h2>";
                echo "<thead><tr><th>Cantidad</th><th>Producto</th><th>Precio Unitario</th><th>Nota del Pedido</th></tr></thead>";

                foreach($result as $row){
                    echo "<tr>";
                    echo "<td data-label='Cantidad'>" . $row['Cantidad'] . "</td>";
                    echo "<td data-label='Producto'>" . $row['Producto'] . "</td>";
                    echo "<td data-label='Precio Unitario'>" . $row['Precio_Unitario'] . "</td>";
                    echo "<td data-label='Precio Unitario'>" . $row['Nota del Pedido'] . "</td>";
                }

                echo "</table>";
                
                echo "</body>";
                echo "</div>";
                echo '</section>';
                echo "</html>";
            }else{
                echo "Pedido no encontrado.";
            }



        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        
    }else{
        echo "ID del pedido no especificado.";
    }

    $conn = null;


?>