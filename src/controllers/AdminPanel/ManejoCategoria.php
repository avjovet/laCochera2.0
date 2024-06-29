<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(realpath(dirname(__FILE__) . '/../../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../../models/categoriaproducto.php'));

header('Content-Type: application/json');

class manejoCategoria {
    private $db;
    private $categoria;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->categoria = new CategoriaProducto($this->db);
    }

    public function insertarCategoria($ArregloProductoJson) {
        $categoriaData = json_decode($ArregloProductoJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'JSON inválido: ' . json_last_error_msg()
            ];
        }

        $this->categoria->NombreCategoria = $categoriaData['nombre'];
        

        if ($this->categoria->crear()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error al crear el categoria'];
        }
    }

    public function eliminarCategoria($idCategoriaProducto) {
        $this->categoria->idCategoriaProducto = $idCategoriaProducto;

        if ($this->categoria->eliminar()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el categoria'];
        }
    }

    public function editarCategoria($idCategoriaProducto, $datosCategoria) {
        $categoriaData = json_decode($datosCategoria, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'JSON inválido: ' . json_last_error_msg()
            ];
        }

        // Obtener el categoria existente
        $categoriaExistente = $this->categoria->obtenerPorId($idCategoriaProducto);

        if ($categoriaExistente) {
            // Actualizar los datos del categoria existente
            $this->categoria->idCategoriaProducto = $idCategoriaProducto;
            $this->categoria->NombreCategoria = $categoriaData['nombre'];
            

            if ($this->categoria->actualizar()) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'Error al actualizar el categoria'];
            }
        } else {
            return ['success' => false, 'message' => 'Producto no encontrado'];
        }
    }

    

    public function ocultar($idCategoriaProducto) {
        // Obtén el categoria existente
        $categoriaExistente = $this->categoria->obtenerPorId($idCategoriaProducto);
    
        if ($categoriaExistente) {
            // Establece el ID del categoria
            $this->categoria->idCategoriaProducto = $idCategoriaProducto;
            
            // Llama a la función ocultar de la clase Producto
            if ($this->categoria->ocultar()) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'Error al ocultar el categoria'];
            }
        } else {
            return ['success' => false, 'message' => 'Producto no encontrado'];
        }
    }
    
      
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $manejoCategoria = new manejoCategoria();

    // Analizar el tipo de solicitud y llamar al método correspondiente
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'insertar':
                $resultado = $manejoCategoria->insertarCategoria($input);
                break;
            case 'eliminar':
                $idCategoriaProducto = isset($_GET['id']) ? $_GET['id'] : null;
                $resultado = $manejoCategoria->eliminarCategoria($idCategoriaProducto);
                break;
            case 'editar':
                $idCategoriaProducto = isset($_GET['id']) ? $_GET['id'] : null;
                $resultado = $manejoCategoria->editarCategoria($idCategoriaProducto, $input);
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
$jsonInsrtar = '{"nombre":"Criollo"}';
$manejoCategoria1 = new manejoCategoria();
$resultado1 = $manejoCategoria1->insertarCategoria($jsonInsrtar);
echo json_encode($resultado1);
*/
if ($_SERVER['REQUEST_METHOD'] === 'OCULT') {
    // Obten el ID del categoria desde la URL
    $idCategoriaProducto = isset($_GET['id']) ? $_GET['id'] : null;
    // Instancia la clase manejoCategoria
    $manejoCategoria = new manejoCategoria();
    // Llama al método eliminarProducto con el ID del categoria
    $resultado = $manejoCategoria->ocultar($idCategoriaProducto);
    // Devuelve la respuesta como JSON
    echo json_encode($resultado);
    // Detén la ejecución del script
    exit();
}

/*
$jsonInsrtar = '{"nombre":"Pizza premium"}';
$busquedaid = 10;
$manejoCategoria1 = new manejoCategoria();
$resultado1 = $manejoCategoria1->editarCategoria($busquedaid,$jsonInsrtar);
echo json_encode("qevfue");

echo json_encode($resultado1);
*/

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Obten el ID del categoria desde la URL
    $idCategoriaProducto = isset($_GET['id']) ? $_GET['id'] : null;
    // Instancia la clase manejoCategoria
    $manejoCategoria = new manejoCategoria();
    // Llama al método eliminarProducto con el ID del categoria
    $resultado = $manejoCategoria->eliminarCategoria($idCategoriaProducto);
    // Devuelve la respuesta como JSON
    echo json_encode($resultado);
    // Detén la ejecución del script
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'EDIT') {
    // Obten el ID del categoria desde la URL
    $idCategoriaProducto = isset($_GET['id']) ? $_GET['id'] : null;
    
    // Obtén los datos del categoria desde la solicitud
    $datosCategoria = file_get_contents('php://input');
    
    // Instancia la clase manejoCategoria
    $manejoCategoria = new manejoCategoria();
    
    // Llama al método editarProducto con el ID del categoria y los datos del categoria
    $resultado = $manejoCategoria->editarCategoria($idCategoriaProducto, $datosCategoria);
    
    // Devuelve la respuesta como JSON
    echo json_encode($resultado);
    
    // Detén la ejecución del script
    exit();
}


/*

$manejoCategoria = new manejoCategoria();

// Llama a la función ocultar con un ID de categoria predeterminado
$idCategoriaProducto = 71; // ID del categoria que deseas ocultar
$resultado = $manejoCategoria->ocultar($idCategoriaProducto);

// Imprime el resultado
echo json_encode($resultado);

*/