<?php
include 'conn/conn.php'; // Incluir el archivo de conexión

try {
    // Preparar la consulta SQL
    $stmt = $conn->prepare("
    SELECT 
        tp.TipoPed AS Tipo_Pedido,
        GROUP_CONCAT(CONCAT(dp.Cantidad, ' ', pr.Nombre) SEPARATOR ', ') AS Productos,
        SUM(dp.Cantidad * pr.Precio) AS Total,
        p.codTrans AS Codigo_Transaccion,  /* Campo añadido para codTrans */
        mp.MedioPa AS Medio_De_Pago,
        c.Direccion AS Direccion_Cliente
    FROM 
        pedido p
    JOIN 
        detallepedido dp ON p.idPedido = dp.Pedido_id
    JOIN 
        producto pr ON dp.Producto_id = pr.idProducto
    JOIN 
        tipopedido tp ON p.TipoPedido_id = tp.idTipoPedido
    JOIN 
        cliente c ON p.Cliente_idCliente = c.idCliente
    JOIN 
        mediopago mp ON p.MedioPago_id = mp.idMedioPago
    WHERE
        p.Estado = 1
    GROUP BY 
        p.idPedido
    ORDER BY
        p.Fecha ASC;  /* Ordenar por fecha de pedido ascendente */
    ");

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iniciar el documento HTML
    echo '<!DOCTYPE html>';
    echo '<html lang="es">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<meta http-equiv="X-UA-Compatible" content="ie=edge">';
    echo '<title>Lista de Pedidos</title>';
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
    echo '<caption>Lista de Pedidos</caption>';
    echo '<thead><tr><th>Tipo Pedido</th><th>Productos</th><th>Total</th><th>Código Transacción</th><th>Medio de Pago</th><th>Dirección Cliente</th></tr></thead>';
    // Iterar sobre cada resultado y mostrarlos en la tabla
    foreach ($result as $row) {
        echo '<tr>';
        echo "<td data-label='Tipo Pedido'>" . htmlspecialchars($row['Tipo_Pedido']) . "</td>";
        echo "<td data-label='Productos'>" . htmlspecialchars($row['Productos']) . "</td>";
        echo "<td data-label='Total'>" . htmlspecialchars($row['Total']) . "</td>";
        echo "<td data-label='Código Transacción'>" . htmlspecialchars($row['Codigo_Transaccion']) . "</td>";
        echo "<td data-label='Medio de Pago'>" . htmlspecialchars($row['Medio_De_Pago']) . "</td>";
        echo "<td data-label='Dirección Cliente'>" . htmlspecialchars($row['Direccion_Cliente']) . "</td>";
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

