<?php
require_once(realpath(dirname(__FILE__) . '/../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../models/usuario.php'));

$database = new Database();
$db = $database->getConnection();

if(isset($_POST['usuario']) && !empty($_POST['usuario']) && isset($_POST['contraseña']) && !empty($_POST['contraseña'])){
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $usuarioModelo = new Usuario($db);
    $usuarioAutenticado = $usuarioModelo->autenticar($usuario, $contraseña);

    if ($usuarioAutenticado) {
        echo json_encode(array('success' => 1));
    } else {
        echo json_encode(array('success' => 0));
    }
}




  /*
  $database = new Database();
  $database->conn = $database->getConnection();
  
  $usua = "lolo";
  $contra = "anecaca";
  $usuario = new Usuario($database->conn);
  $usuarioIs = $usuario->autenticar($usua, $contra);
  
  echo json_encode($usuarioIs);*/

