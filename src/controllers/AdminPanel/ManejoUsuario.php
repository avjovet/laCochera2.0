<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(realpath(dirname(__FILE__) . '/../../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../../models/usuario.php'));

header('Content-Type: application/json');

class manejoUsuario {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function insertarUsuario($ArregloUsuarioJson) {
        $UsuarioData = json_decode($ArregloUsuarioJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'JSON invalido: ' . json_last_error_msg()
            ];
        }

        $this->usuario->Nombre = $UsuarioData['nombre'];
        $this->usuario->Usua = $UsuarioData['usuario'];
        $this->usuario->Contraseña = $UsuarioData['contraseña'];
        $this->usuario->TipoUsuario_id = $UsuarioData['categoria'];

        echo "Atributos del objeto usuario:";
        echo "<pre>";
        var_dump($this->usuario);
        echo "</pre>";

        if ($this->usuario->crear()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error al crear el usuario'];
        }
    }

    public function eliminarUsuario($idUsuario) {
        $this->usuario->idUsuario = $idUsuario;

        if ($this->usuario->eliminar()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el usuario'];
        }
    }

    public function editarUsuario($idUsuario, $datosUsuario) {
        $UsuarioData = json_decode($datosUsuario, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'JSON inválido: ' . json_last_error_msg()
            ];
        }

        // Obtener el usuario existente
        $UsuarioExistente = $this->usuario->obtenerPorId($idUsuario);

        if ($UsuarioExistente) {
            // Actualizar los datos del usuario existente
            $this->usuario->idUsuario = $idUsuario;
            $this->usuario->Nombre = $UsuarioData['nombre'];
            $this->usuario->Usua = $UsuarioData['usuario'];
            $this->usuario->Contraseña = $UsuarioData['contraseña'];
            $this->usuario->TipoUsuario_id = $UsuarioData['categoria'];

            if ($this->usuario->actualizar()) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'Error al actualizar el usuario'];
            }
        } else {
            return ['success' => false, 'message' => 'Usuario no encontrado'];
        }
    }
    
      
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $manejoUsuario = new manejoUsuario();

    // Analizar el tipo de solicitud y llamar al método correspondiente
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'insertar':
                $resultado = $manejoUsuario->insertarUsuario($input);
                break;
            case 'eliminar':
                $idUsuario = isset($_GET['id']) ? $_GET['id'] : null;
                $resultado = $manejoUsuario->eliminarUsuario($idUsuario);
                break;
            case 'editar':
                $idUsuario = isset($_GET['id']) ? $_GET['id'] : null;
                $resultado = $manejoUsuario->editarUsuario($idUsuario, $input);
                break;
            default:
                $resultado = ['success' => false, 'message' => 'Acción no válida'];
        }
    } else {
        $resultado = ['success' => false, 'message' => 'Acción no especificada'];
    }

    echo json_encode($resultado);
}

/*
$input = '{"nombre":"Isabel","usuario":"Isa7777","contraseña":"12345","contraseña2":"12345","categoria":"2"}';

$manejoUsuario = new manejoUsuario();
$resultado = $manejoUsuario->insertarUsuario($input);
echo json_encode($resultado);

*/

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Obten el ID del usuario desde la URL
    $idUsuario = isset($_GET['id']) ? $_GET['id'] : null;
    // Instancia la clase manejoUsuario
    $manejoUsuario = new manejoUsuario();
    // Llama al método eliminarUsuario con el ID del usuario
    $resultado = $manejoUsuario->eliminarUsuario($idUsuario);
    // Devuelve la respuesta como JSON
    echo json_encode($resultado);
    // Detén la ejecución del script
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'EDIT') {
    // Obten el ID del usuario desde la URL
    $idUsuario = isset($_GET['id']) ? $_GET['id'] : null;
    
    // Obtén los datos del usuario desde la solicitud
    $datosUsuario = file_get_contents('php://input');
    
    // Instancia la clase manejoUsuario
    $manejoUsuario = new manejoUsuario();
    
    // Llama al método editarUsuario con el ID del usuario y los datos del usuario
    $resultado = $manejoUsuario->editarUsuario($idUsuario, $datosUsuario);
    
    // Devuelve la respuesta como JSON
    echo json_encode($resultado);
    
    // Detén la ejecución del script
    exit();
}
/*
$idpe=7;
$Datoto = '{"nombre":"coco","usuario":"qeqe","contraseña":"12345","contraseña2":"12345","categoria":"1"}';

$manejoUsuario1 = new manejoUsuario();
$resultado1 = $manejoUsuario1->editarUsuario($idpe, $Datoto);
echo json_encode($resultado1);
*/

