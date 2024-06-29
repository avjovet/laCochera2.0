<?php
include 'conn/conn.php'; // Incluir el archivo de conexión

// Verificar si se ha enviado la solicitud para cambiar el estado de llamado
if (isset($_POST['mesa_id'])) {
    $mesa_id = $_POST['mesa_id'];

    try {
        // Actualizar el valor de llamado a 0 para la mesa seleccionada
        $stmt = $conn->prepare("
            UPDATE mesa 
            SET llamado = 0 
            WHERE idMesa = :mesa_id
        ");
        $stmt->bindParam(':mesa_id', $mesa_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirigir a pedidos-mesa.php
        header("Location: pedidos-mesa.php?mesa_id=" . $mesa_id);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    // Preparar la consulta SQL para obtener las mesas que tienen llamado=1
    $stmt = $conn->prepare("
        SELECT 
            m.idMesa, 
            COUNT(p.idPedido) AS CantidadPedidos
        FROM 
            mesa m
        LEFT JOIN 
            pedido p ON m.idMesa = p.Mesa_id
        WHERE 
            m.llamado = 1
        GROUP BY 
            m.idMesa
        ORDER BY 
            m.FechaLlamado ASC
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
    echo '<title>Mesas con Llamado</title>';
    echo '<link rel="stylesheet" type="text/css" href="F.css">';
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">';
    echo '</head>';
    echo '<body>';
    include 'sidebar.php';
    
    echo '<section class="home-section">';
    echo '<div class="container">';
    echo '<h2>Mesas que han llamado</h2>';
    
    if (!empty($mesas)) {
        echo '<div class="mesas-container">';
        foreach ($mesas as $mesa) {
            echo '<div class="mesa">Mesa ' . htmlspecialchars($mesa['idMesa']) . '<br>';
            echo htmlspecialchars($mesa['CantidadPedidos']) . ' pedidos<br>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="mesa_id" value="' . htmlspecialchars($mesa['idMesa']) . '">';
            echo '<button type="submit" class="ver-pedidos-button">Atender </button>';
            echo '</form>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No hay mesas con llamado activo.</p>';
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
