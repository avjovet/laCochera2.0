<?php
include 'conn/conn.php'; // Incluir el archivo de conexión

if(isset($_POST['llamar'])) {
    $mesa_id = $_POST['mesa_id'];

    try {
        // Preparar la consulta SQL para actualizar el campo 'llamado' a 1
        $stmt = $conn->prepare("
            UPDATE mesa
            SET llamado = 1
            WHERE idMesa = :mesa_id
        ");

        // Asociar el parámetro del ID de la mesa
        $stmt->bindParam(':mesa_id', $mesa_id, PDO::PARAM_INT);
+
        // Ejecutar la actualización
        $stmt->execute();

        header("Location: ".$_SERVER['PHP_SELF']."?mesa=".$mesa_id);
        exit();


    } catch(PDOException $e) {
        echo "Error al realizar el llamado: " . $e->getMessage();
    }
}

// Verificar si se ha enviado el ID de la mesa
if (isset($_GET['mesa'])) {
    $mesa_id = $_GET['mesa'];

    try {
        // Preparar la consulta SQL para obtener la información de la mesa específica
        $stmt = $conn->prepare("
            SELECT 
                idMesa,
                llamado
            FROM 
                mesa
            WHERE
                idMesa = :mesa_id
        ");

        // Asociar el parámetro del ID de la mesa
        $stmt->bindParam(':mesa_id', $mesa_id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Mostrar la información de la mesa
        if ($result) {
            echo "<!DOCTYPE html>";
            echo "<html>";
            echo "<head>";
            echo "<title>Estado de la Mesa</title>";
            echo "<link rel='stylesheet' type='text/css' href='styles.css'>";
            echo "</head>";
            echo "<body>";
            echo "<h2>Mesa: " . htmlspecialchars($mesa_id) . "</h2>";
            echo "<p>Llamado: " . (htmlspecialchars($result['llamado']) ? 'Sí' : 'No') . "</p>";

            echo "<form method='post'>";
            echo "<input type='hidden' name='mesa_id' value='" . $mesa_id . "'>";
            echo "<input type='submit' name='llamar' value='Llamar'>";
            echo "</form>";
            echo "</body>";
            echo "</html>";
        } else {
            echo "Mesa no encontrada.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ID de la mesa no especificado.";
}

// Cerrar la conexión
$conn = null;
?>
