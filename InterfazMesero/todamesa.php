<?php
include 'conn/conn.php'; // Incluir el archivo de conexión

try {
    $stmt = $conn->prepare("
        SELECT 
            idMesa 
        FROM 
            mesa
    ");

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iniciar el documento HTML
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<meta http-equiv="X-UA-Compatible" content="ie=edge">';
    echo '<title>Mesas</title>';
    echo '<link rel="stylesheet" type="text/css" href="F.css">'; // Enlace al archivo CSS
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">';
    echo '</head>';
    echo '<body>';
    include 'sidebar.php';
    
    echo '<section class="home-section">';
    echo '<div class="container">';
    echo '<h2>Mesas</h2>';
    
    if (!empty($mesas)) {
        echo '<div class="mesas-container">';
        foreach ($mesas as $mesa) {
            echo '<div class="mesa">Mesa ' . htmlspecialchars($mesa['idMesa']) . '<br>';
            echo '<form method="get" action="pedidos-mesa.php">'; // Cambiado el método a GET
            echo '<input type="hidden" name="mesa_id" value="' . htmlspecialchars($mesa['idMesa']) . '">';
            echo '<button type="submit" class="ver-p-button">Ver pedido</button>';
            echo '</form>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No hay mesas disponibles.</p>';
    }

    echo '</div>';
    echo '</section>';
    echo '</body>';
    echo '</html>';

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
