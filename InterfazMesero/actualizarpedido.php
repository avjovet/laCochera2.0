<?php
include 'conn/conn.php'; // Incluir el archivo de conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Actualización de datos
    try {
        // Iniciar una transacción
        $conn->beginTransaction();

        // Recorrer los datos enviados por el formulario
        foreach ($_POST['detalle_pedido_id'] as $index => $detalle_pedido_id) {
            $cantidad = $_POST['cantidad'][$index];
            $producto_id = $_POST['producto'][$index];
            $notas = $_POST['notas'][$index];
            $precio = 2; // Valor predeterminado para el precio
            $fecha = date('Y-m-d H:i:s'); // Fecha y hora actuales

            if ($detalle_pedido_id == '0') {
                // Insertar un nuevo detalle de pedido
                $stmt = $conn->prepare("
                    INSERT INTO detallepedido (Cantidad, Producto_id, NotaPedido, Pedido_id, Precio, Fecha)
                    VALUES (:cantidad, :producto_id, :notas, :pedido_id, :precio, :fecha)
                ");
                $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
                $stmt->bindParam(':notas', $notas, PDO::PARAM_STR);
                $stmt->bindParam(':pedido_id', $_POST['pedido_id'], PDO::PARAM_INT);
                $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);
                $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                $stmt->execute();
            } else {
                // Actualizar un detalle de pedido existente
                $stmt = $conn->prepare("
                    UPDATE detallepedido 
                    SET Cantidad = :cantidad, Producto_id = :producto_id, NotaPedido = :notas 
                    WHERE idDetallePedido = :detalle_pedido_id
                ");
                $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
                $stmt->bindParam(':notas', $notas, PDO::PARAM_STR);
                $stmt->bindParam(':detalle_pedido_id', $detalle_pedido_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        // Manejar la eliminación de detalles de pedido
        if (isset($_POST['eliminar_detalle_pedido_id'])) {
            foreach ($_POST['eliminar_detalle_pedido_id'] as $detalle_pedido_id) {
                $stmt = $conn->prepare("
                    DELETE FROM detallepedido WHERE idDetallePedido = :detalle_pedido_id
                ");
                $stmt->bindParam(':detalle_pedido_id', $detalle_pedido_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        // Confirmar la transacción
        $conn->commit();

        // Redirigir de nuevo a la página del pedido con un mensaje de éxito
        header("Location: ?pedido_id=" . $_POST['pedido_id'] . "&success=1");
        exit;
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else if (isset($_GET['pedido_id'])) {
    // Mostrar datos
    $pedido_id = $_GET['pedido_id'];
    $total_pedido = 0; // Inicializar el total del pedido

    try {
        // Preparar la consulta SQL para obtener la información del pedido específico
        $stmt = $conn->prepare("
            SELECT 
                p.idPedido,
                dp.idDetallePedido,
                dp.Cantidad,
                pr.Nombre AS Producto,
                pr.Precio AS Precio_Unitario,
                dp.NotaPedido AS Notas,
                pr.idProducto
            FROM 
                pedido p
            LEFT JOIN 
                detallepedido dp ON p.idPedido = dp.Pedido_id
            JOIN 
                producto pr ON dp.Producto_id = pr.idProducto
            WHERE
                p.idPedido = :pedido_id
        ");
        $stmt->bindParam(':pedido_id', $pedido_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener todos los productos para la lista desplegable
        $stmtProductos = $conn->prepare("SELECT idProducto, Nombre, Precio FROM producto");
        $stmtProductos->execute();
        $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

        // Mostrar la información del pedido
        echo "<!DOCTYPE html>";
        echo "<html>";
        echo "<head>";
        echo "<title>Detalle del Pedido</title>";
        echo "<link rel='stylesheet' type='text/css' href='F.css'>";
        echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>";
        echo "</head>";
        echo "<body>";
        include 'sidebar.php';
        echo '<section class="home-section">';
        echo "<div class='container'>";
        echo "<h2>ID del Pedido: " . htmlspecialchars($pedido_id) . "</h2>";
        echo "<form method='post' action=''>";
        echo "<table class='table' id='pedido-table'>";
        echo "<thead>
        <tr><th>Cantidad</th><th>Producto</th><th>Notas</th><th>Precio Unitario</th><th>Acciones</th></tr>
        </thead><tbody>";

        if ($result) {
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td data-label='Cantidad'><input type='number' name='cantidad[]' value='" . htmlspecialchars($row['Cantidad']) . "' class='cantidad-input'></td>";
                echo "<td data-label='Producto'><select name='producto[]' class='producto-select'>";
                foreach ($productos as $producto) {
                    $selected = ($producto['idProducto'] == $row['idProducto']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($producto['idProducto']) . "' data-precio='" . htmlspecialchars($producto['Precio']) . "' " . $selected . ">" . htmlspecialchars($producto['Nombre']) . "</option>";
                }
                echo "</select></td>";
                echo "<td data-label='Notas'><input type='text' name='notas[]' value='" . htmlspecialchars($row['Notas']) . "'></td>";
                echo "<td data-label='Precio Unitario' class='precio-unitario'>" . htmlspecialchars($row['Precio_Unitario']) . "</td>";
                echo "<td data-label='Acciones' class='actions'>";
                echo '<button class="boton-cancelar" type="button">X Cancelar</button>';
                echo "<input type='hidden' name='detalle_pedido_id[]' value='" . htmlspecialchars($row['idDetallePedido']) . "'>";
                echo "</td>";
                echo "</tr>";
                $total_pedido += ($row['Cantidad'] * $row['Precio_Unitario']);
            }
        } else {
            echo "<tr>";
            echo "<td colspan='5'>No hay detalles de pedido, puedes agregar uno.</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
        echo "<p id='total-display'>Total: $" . htmlspecialchars($total_pedido) . "</p>";
        echo "<button class='actualiza-pedido' type='submit'>Actualizar</button>";
        echo "<button class='agrega-fi' type='button' id='agregar-fila'>Agregar</button>";
        echo "<input type='hidden' name='pedido_id' value='" . htmlspecialchars($pedido_id) . "'>";
        echo "<input type='hidden' name='eliminar_detalle_pedido_id[]' id='eliminar_detalle_pedido_id'>";
        echo "</form>";
        echo "</div>";
        echo '</section>';
        echo "<script src='e.js'></script>";
        echo "</body>";
        echo "</html>";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ID del pedido no especificado.";
}
// Cerrar la conexión
$conn = null;
?>
