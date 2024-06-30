<?php

include 'conn/conn.php';

// Consulta para obtener la cantidad de pedidos pendientes
$sql = "SELECT COUNT(*) AS pending_count
FROM pedido p
WHERE p.Estado = 1
AND p.Mesa_id IS NOT NULL
AND EXISTS (
    SELECT 1
    FROM detallepedido dp
    WHERE dp.Pedido_id = p.idPedido
);";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo $row['pending_count'];

// Cierra la conexión
$conn = null;
?>
