<?php
include 'conn/conn.php';

// Procesar la inserción de un nuevo pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo_pedido'])) {
    $tipo_pedido = $_POST['tipo_pedido'];
    $mesa_id = ($tipo_pedido == 2) ? 34 : ($_POST['mesa_id'] ?? null); // Si tipo_pedido es 2, usamos Mesa_id = 34

    // Validar que el tipo de pedido y la mesa sean válidos
    if (empty($tipo_pedido) || ($tipo_pedido == 1 && empty($mesa_id))) {
        $error = "Por favor, selecciona un número de mesa.";
    } else {
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
            $stmt->bindParam(':mesa_id', $mesa_id, PDO::PARAM_INT);
            $stmt->execute();

            // Obtener el ID del pedido insertado
            $pedido_id = $conn->lastInsertId();

            // Confirmar la transacción
            $conn->commit();

            // Redirigir a la página de actualización de pedidos
            header("Location: nuevopedido.php?pedido_id=" . $pedido_id);
            exit();
        } catch (PDOException $e) {
            $conn->rollBack();
            $error = "Error: " . $e->getMessage();
        }
    }
}

try {
    // Obtener todos los tipos de pedido y mesas para la selección
    $stmtTipos = $conn->prepare("SELECT idTipoPedido, TipoPed FROM tipopedido WHERE idTipoPedido IN (1, 2)");
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

    // Mostrar mensaje de error si hay uno
    if (isset($error)) {
        echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
    }

    echo '<p>Tipo de Pedido:</p>';
    echo '<select name="tipo_pedido" id="tipo_pedido" required>';
    echo '<option value="">Selecciona</option>'; // Opción por defecto
    foreach ($tipos_pedido as $tipo) {
        echo '<option value="' . htmlspecialchars($tipo['idTipoPedido']) . '">' . htmlspecialchars($tipo['TipoPed']) . '</option>';
    }
    echo '</select>';

    echo '<div id="mesa-container" style="display:none;">';
    echo '<p>Número de Mesa:</p>';
    echo '<select name="mesa_id" id="mesa_id">';
    echo '<option value="">Selecciona</option>'; // Opción por defecto
    foreach ($mesas as $mesa) {
        echo '<option value="' . htmlspecialchars($mesa['idMesa']) . '">' . htmlspecialchars($mesa['NumMesa']) . '</option>';
    }
    echo '</select>';
    echo '</div>';

    echo '<button class="agrega-pedido" type="submit">Agregar Pedido</button>';

    echo '</form>';
    echo '</div>';
    echo '</section>';
    echo '<script src="agregar_pedido.js"></script>'; // Asegúrate de incluir el archivo JS
    echo '</body>';
    echo '</html>';
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
