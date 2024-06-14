<?php

// Incluye el archivo donde se define la clase ManejoMesa
require_once(realpath(dirname(__FILE__) . '/../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../models/mesa.php'));


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obten el ID del producto desde la URL
    $idMesa = isset($_GET['idMesa']) ? $_GET['idMesa'] : null;
    // Instancia la clase manejoProducto

    
     
    $database = new Database();
    $db = $database->getConnection();
    // Crea una instancia de la clase ManejoMesa y configura la conexión a la base de datos
   
    
    // Crea una instancia de la clase Mesa y configura la conexión a la base de datos
    $mesa = new Mesa($db); // Reemplaza $db con tu objeto de conexión a la base de datos
    $mesa->idMesa = $idMesa;
    

    $mesa->actualizarLlamado();
    
    // Detén la ejecución del script
    
}


if ($_SERVER['REQUEST_METHOD'] === 'POST2') {
    // Obten el ID del producto desde la URL
    $idMesa = isset($_GET['idMesa']) ? $_GET['idMesa'] : null;
    // Instancia la clase manejoProducto

    
     
    $database = new Database();
    $db = $database->getConnection();
    // Crea una instancia de la clase ManejoMesa y configura la conexión a la base de datos
   
    
    // Crea una instancia de la clase Mesa y configura la conexión a la base de datos
    $mesa = new Mesa($db); // Reemplaza $db con tu objeto de conexión a la base de datos
    $mesa->idMesa = $idMesa;
    

    $mesa->actualizarLlamado2();
    
    // Detén la ejecución del script
    
}
/*
// Verifica si se ha recibido el idMesa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene el idMesa del cuerpo de la solicitud
    $idMesa = intval($_POST['idMesa']);

    
    $database = new Database();
    $db = $database->getConnection();
    // Crea una instancia de la clase ManejoMesa y configura la conexión a la base de datos
   
    

    // Crea una instancia de la clase Mesa y configura la conexión a la base de datos
    $mesa = new Mesa($db);
    
    // Reemplaza $db con tu objeto de conexión a la base de datos
    $mesa->idMesa = $idMesa;
    

    // Llama al método actualizarLlamado para actualizar el campo Llamado en la tabla mesa
    if($mesa->actualizarLlamado()) {

        // Si la actualización fue exitosa, envía una respuesta exitosa
        echo json_encode(array("message" => "Llamado mandado"));
    } else {
        // Si hubo un error en la actualización, envía un mensaje de error
        echo json_encode(array("message" => "Error en el envío"));
    }
} else {
    // Si no se recibió el idMesa en la solicitud, envía un mensaje de error
    echo json_encode(array("message" => "Falta el parámetro idMesa"));
}*/
/*
    $idMesa2 = 1;  
    
    $database = new Database();
    $db = $database->getConnection();
    // Crea una instancia de la clase ManejoMesa y configura la conexión a la base de datos
   
    
    // Crea una instancia de la clase Mesa y configura la conexión a la base de datos
    $mesa = new Mesa($db); // Reemplaza $db con tu objeto de conexión a la base de datos
    $mesa->idMesa = $idMesa2;
    

    $mesa->actualizarLlamado()
    */


?>
