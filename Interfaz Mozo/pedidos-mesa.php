<?php
include 'conn/conn.php'; // Incluir el archivo de conexión

// Verificar si se ha enviado el ID de la mesa a través de GET
if (isset($_GET['mesa_id'])) {
    $mesa_id = $_GET['mesa_id']; // Obtener el ID de la mesa desde la URL

    try {
        // Preparar la consulta SQL para obtener los pedidos de la mesa especificada
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
                m.idMesa = :mesa_id
            GROUP BY 
                p.idPedido;
        ");

        // Asociar el parámetro del ID de la mesa
        $stmt->bindParam(':mesa_id', $mesa_id, PDO::PARAM_INT);

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
        echo '<title>Pedidos de la mesa</title>';
        echo '<link rel="stylesheet" type="text/css" href="F.css">';
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">';
        echo '</head>';
        echo '<body>';
        include 'sidebar.php';

        echo '<section class="home-section">';
        echo '<div class="container">';
        echo '<h2>Pedidos de la mesa ' . htmlspecialchars($mesa_id) . '</h2>';

        // Mostrar la tabla de pedidos
        echo '<table class="table">';
        echo '<caption>Pedidos</caption>';
        echo '<thead><tr><th>Fecha Pedido</th><th>Numero Mesa</th><th>Tipo Pedido</th><th>Productos</th><th>Total</th><th>Estado Pedido</th></tr></thead>';
        echo '<tbody>';
        foreach ($result as $row) {
            echo '<tr>';
            echo "<td>" . $row['Fecha_Pedido'] . "</td>";
            echo "<td>" . $row['Numero_Mesa'] . "</td>";
            echo "<td>" . $row['Tipo_Pedido'] . "</td>";
            echo "<td>" . $row['Productos'] . "</td>";
            echo "<td>" . $row['Total'] . "</td>";
            echo "<td>" . $row['Estado_Pedido'] . "</td>";
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';

        echo '</div>';
        echo '</section>';
        echo '</body>';
        echo '</html>';

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si el ID de la mesa no está especificado, mostrar un mensaje de error
    echo "ID de la mesa no especificado.";
}

// Cerrar la conexión
$conn = null;
?>
