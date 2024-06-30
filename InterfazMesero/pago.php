<?php
include 'conn/conn.php'; // Incluir el archivo de conexión

try {
    // Preparar la consulta SQL
    $stmt = $conn->prepare("
    SELECT 
        p.idPedido,
        DATE_FORMAT(p.Fecha, '%Y-%m-%d') AS Fecha_Pedido,
        CASE 
            WHEN m.NumMesa = 100 THEN 'C'
            WHEN m.NumMesa = 101 THEN 'D'
            ELSE m.NumMesa 
        END AS Numero_Mesa,
        tp.TipoPed AS Tipo_Pedido,
        GROUP_CONCAT(CONCAT(dp.Cantidad, ' ', pr.Nombre) SEPARATOR ', ') AS Productos,
        SUM(dp.Cantidad * pr.Precio) AS Total,
        e.nombre AS Estado_Pedido,
        p.codtrans AS Cod_Trans
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
        p.Estado = 1 AND p.Mesa_id = 22
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
    echo '<thead><tr><th>Fecha Pedido</th><th>Numero Mesa</th><th>Tipo Pedido</th><th>Productos</th><th>Total</th><th>Estado Pedido</th><th>Cod Trans</th></tr></thead>';
    // Iterar sobre cada resultado y mostrarlos en la tabla
    foreach ($result as $row) {
        echo '<tr>';
        echo "<td data-label='Fecha Pedido'>" . htmlspecialchars($row['Fecha_Pedido']) . "</td>";
        echo "<td data-label='Numero Mesa'>" . htmlspecialchars($row['Numero_Mesa']) . "</td>";
        echo "<td data-label='Tipo Pedido'>" . htmlspecialchars($row['Tipo_Pedido']) . "</td>";
        echo "<td data-label='Productos'>" . htmlspecialchars($row['Productos']) . "</td>";
        echo "<td data-label='Total'>" . htmlspecialchars($row['Total']) . "</td>";
        echo "<td data-label='Estado Pedido'>" . htmlspecialchars($row['Estado_Pedido']) . "</td>";
        echo "<td data-label='Cod Trans'>" . htmlspecialchars($row['Cod_Trans']) . "</td>";
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
