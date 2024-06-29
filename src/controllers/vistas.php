<?php
require_once(realpath(dirname(__FILE__) . '\..\config\conection.php'));

$database = new Database();
$conn = $database->getConnection();

// Función para obtener datos de una vista
function obtenerDatosVista($conn, $vista) {
    $sql = "SELECT * FROM $vista";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Nombres de las vistas
$vistas = [
    "precioTotal_productos",
    "cant_tipoPedido",
    "Totalpedidos_porFecha",
    "mesa_pedidos",
    "agregado_vendido", // Corrigí los nombres para que no tengan caracteres no permitidos
    "bebida_vendida",
    "hamburguesas_vendidas",
    "plato_vendido",
    "Totalpedidos_porDiaSemana"
];

// Array asociativo para almacenar los datos de todas las vistas
$resultado = [];

foreach ($vistas as $vista) {
    $resultado[$vista] = obtenerDatosVista($conn, $vista);
}

// Devolver los datos en formato JSON
echo json_encode($resultado);
?>
