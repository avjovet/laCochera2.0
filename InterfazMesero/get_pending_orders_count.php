<?php

include 'conn/conn.php';

// Consulta para obtener la cantidad de pedidos pendientes
$sql = "SELECT COUNT(*) AS pending_count FROM pedido WHERE Estado = 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo $row['pending_count'];

// Cierra la conexión
$conn = null;
?>
