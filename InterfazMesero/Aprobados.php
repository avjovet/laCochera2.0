<?php
include 'conn/conn.php'; // Incluir el archivo de conexión

// Verificar si se ha enviado un formulario para cancelar un pedido
if (isset($_POST['accion_pedido'])) {
    $pedido_id = $_POST['pedido_id'];
    $accion = $_POST['accion_pedido'];
    try {
        if ($accion == 'cancelar') {
            // Actualizar el estado del pedido a "Pendiente" en la base de datos
            $stmt = $conn->prepare("UPDATE pedido SET Estado = 1 WHERE idPedido = :pedido_id");
            $stmt->bindParam(':pedido_id', $pedido_id);
            $stmt->execute();
            // Redirigir después de procesar el formulario
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    // Preparar la consulta SQL
    $stmt = $conn->prepare("
    SELECT 
        p.idPedido,
        DATE_FORMAT(p.Fecha, '%Y-%m-%d') AS Fecha_Pedido,
        m.NumMesa AS Numero_Mesa,
        tp.TipoPed AS Tipo_Pedido,
        GROUP_CONCAT(CONCAT(dp.Cantidad, ' ', pr.Nombre) SEPARATOR ', ') AS Productos,
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
        p.Estado = 2
    GROUP BY 
        p.idPedido
    ORDER BY
        p.FechaAprobacion ASC;  -- Ordenar por fecha de aprobación ascendente
");


    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iniciar el documento HTML
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<meta http-equiv="X-UA-Compatible" content="ie=edge">';
    echo '<title>Tabla de Pedidos Aprobados</title>';
    echo '<link rel="stylesheet" type="text/css" href="F.css">';
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">';
    echo '</head>';
    echo '<body>';
    
    include 'sidebar.php';
    
    // Iniciar el contenedor
    echo '<section class="home-section">';
    echo '<div class="container">';
    // Iniciar la tabla
    echo '<table class="table">';
    echo '<caption>Lista Pedidos Aprobados</caption>';
    echo '<thead><tr><th>Fecha Pedido</th><th>Numero Mesa</th><th>Tipo Pedido</th><th>Productos</th><th>Total</th><th>Estado Pedido</th><th>Acciones</th></tr></thead>';
    // Iterar sobre cada resultado y mostrarlos en la tabla
    foreach ($result as $row) {
        echo '<tr>';
        echo "<td data-label='Fecha Pedido'>" . $row['Fecha_Pedido'] . "</td>";
        echo "<td data-label='Numero Mesa'>" . $row['Numero_Mesa'] . "</td>";
        echo "<td data-label='Tipo Pedido'>" . $row['Tipo_Pedido'] . "</td>";
        echo "<td data-label='Productos'>" . $row['Productos'] . "</td>";
        echo "<td data-label='Total'>" . $row['Total'] . "</td>";
        echo "<td data-label= 'Estado'>" . $row['Estado_Pedido'] . "</td>";
        echo '<td data-label="Acciones" class="actions">';
        // Formulario para cancelar el pedido
        echo '<form method="post">';
        echo '<input type="hidden" name="pedido_id" value="' . $row['idPedido'] . '">';
        echo '<input type="hidden" name="accion_pedido" value="cancelar">';
        echo '<button class="cancel-button" type="submit">X Cancelar</button>';
        echo '</form>';
        echo '</tr>';
    }
    // Cerrar la tabla y el contenedor
    echo '</table>';
    echo '</div>';
    echo '</section>';
    echo '</body>';
    echo '</html>';
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
