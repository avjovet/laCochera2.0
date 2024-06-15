<?php
include 'conn/conn.php';

// Procesar la inserción de un nuevo pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo_pedido']) && isset($_POST['mesa_id'])) {
    $tipo_pedido = $_POST['tipo_pedido'];
    $mesa_id = $_POST['mesa_id'];
    $fecha_pedido = date('Y-m-d H:i:s');

    try {
        $conn->beginTransaction();

        // Insertar un nuevo pedido
        $stmt = $conn->prepare("
            INSERT INTO pedido (Estado, Fecha, TipoPedido_id, Mesa_id)
            VALUES (1, :fecha, :tipo_pedido, :mesa_id)
        ");
        $stmt->bindParam(':fecha', $fecha_pedido);
        $stmt->bindParam(':tipo_pedido', $tipo_pedido);
        $stmt->bindParam(':mesa_id', $mesa_id);
        $stmt->execute();

        // Obtener el ID del pedido insertado
        $pedido_id = $conn->lastInsertId();

        // Confirmar la transacción
        $conn->commit();

        // Redirigir a la página de actualización de pedidos
        header("Location: actualizarpedido.php?pedido_id=" . $pedido_id);
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

try {
    // Obtener todos los tipos de pedido y mesas para la selección
    $stmtTipos = $conn->prepare("SELECT idTipoPedido, TipoPed FROM tipopedido");
    $stmtTipos->execute();
    $tipos_pedido = $stmtTipos->fetchAll(PDO::FETCH_ASSOC);

    $stmtMesas = $conn->prepare("SELECT idMesa, NumMesa FROM mesa");
    $stmtMesas->execute();
    $mesas = $stmtMesas->fetchAll(PDO::FETCH_ASSOC);

    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Agregar Pedido</title>';
    echo '<link rel="stylesheet" href="F.css">';
    echo '</head>';
    echo '<body>';
    include 'sidebar.php';
    echo '<section class="home-section">';
    echo '<div class="container">';
    echo '<h1>Agregar Nuevo Pedido</h1>';
    echo '<form method="post" action="">';
    echo '<p>Tipo de Pedido:</p>';
    echo '<select name="tipo_pedido" required>';
    foreach ($tipos_pedido as $tipo) {
        echo '<option value="' . htmlspecialchars($tipo['idTipoPedido']) . '">' . htmlspecialchars($tipo['TipoPed']) . '</option>';
    }
    echo '</select>';

    echo '<p>Número de Mesa:</p>';
    echo '<select name="mesa_id" required>';
    foreach ($mesas as $mesa) {
        echo '<option value="' . htmlspecialchars($mesa['idMesa']) . '">' . htmlspecialchars($mesa['NumMesa']) . '</option>';
    }
    echo '</select>';

    echo '<button type="submit">Agregar Pedido</button>';
    echo '</form>';
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
