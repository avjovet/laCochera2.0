<?php
require_once '..\src\config\conection.php';


$database = new Database();
$conn = $database->getConnection();

// Verifica la conexión
if ($conn) {
    // Query para seleccionar todos los elementos de la tabla historial
    $query = "SELECT * FROM historial ORDER BY id desc" ;
    
    // Ejecutar la consulta
    $result = $conn->query($query);

    // Verificar si hay resultados
    if ($result->rowCount() > 0) {
        // Obtener los resultados como un array asociativo
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        
        // Imprimir los resultados en formato JSON
        echo json_encode($rows);
    } else {
        echo json_encode(["message" => "No se encontraron registros en la tabla historial."]);
    }

    // Liberar el resultado
    $result->closeCursor();

    // Cerrar la conexión
    $conn = null;
} else {
    echo json_encode(["error" => "Error al conectar a la base de datos."]);
}