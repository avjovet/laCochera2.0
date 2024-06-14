<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(realpath(dirname(__FILE__) . '/../../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../../models/producto.php'));

header('Content-Type: application/json');

class manejoProducto {
    private $db;
    private $producto;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
    }

    public function insertarProducto($ArregloProductoJson) {
        $productoData = json_decode($ArregloProductoJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'JSON inválido: ' . json_last_error_msg()
            ];
        }

        $this->producto->nombre = $productoData['nombre'];
        $this->producto->precio = $productoData['precio'];
        $this->producto->imagen = $productoData['imagen'];
        $this->producto->categoria = $productoData['categoria'];

        if ($this->producto->crear()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error al crear el producto'];
        }
    }

    public function eliminarProducto($idProducto) {
        $this->producto->idProducto = $idProducto;

        if ($this->producto->eliminar()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el producto'];
        }
    }

    public function editarProducto($idProducto, $datosProducto) {
        $productoData = json_decode($datosProducto, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'JSON inválido: ' . json_last_error_msg()
            ];
        }

        // Obtener el producto existente
        $productoExistente = $this->producto->obtenerPorId($idProducto);

        if ($productoExistente) {
            // Actualizar los datos del producto existente
            $this->producto->idProducto = $idProducto;
            $this->producto->nombre = $productoData['nombre'];
            $this->producto->precio = $productoData['precio'];
            $this->producto->imagen = $productoData['imagen'];
            $this->producto->categoria = $productoData['categoria'];

            if ($this->producto->actualizar()) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'Error al actualizar el producto'];
            }
        } else {
            return ['success' => false, 'message' => 'Producto no encontrado'];
        }
    }

    public function ocultar($idProducto) {
        // Obtén el producto existente
        $productoExistente = $this->producto->obtenerPorId($idProducto);
    
        if ($productoExistente) {
            // Establece el ID del producto
            $this->producto->idProducto = $idProducto;
            
            // Llama a la función ocultar de la clase Producto
            if ($this->producto->ocultar()) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'Error al ocultar el producto'];
            }
        } else {
            return ['success' => false, 'message' => 'Producto no encontrado'];
        }
    }
    
      
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $manejoProducto = new manejoProducto();

    // Analizar el tipo de solicitud y llamar al método correspondiente
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'insertar':
                $resultado = $manejoProducto->insertarProducto($input);
                break;
            case 'eliminar':
                $idProducto = isset($_GET['id']) ? $_GET['id'] : null;
                $resultado = $manejoProducto->eliminarProducto($idProducto);
                break;
            case 'editar':
                $idProducto = isset($_GET['id']) ? $_GET['id'] : null;
                $resultado = $manejoProducto->editarProducto($idProducto, $input);
                break;
            default:
                $resultado = ['success' => false, 'message' => 'Acción no válida'];
        }
    } else {
        $resultado = ['success' => false, 'message' => 'Acción no especificada'];
    }

    echo json_encode($resultado);
}

if ($_SERVER['REQUEST_METHOD'] === 'OCULT') {
    // Obten el ID del producto desde la URL
    $idProducto = isset($_GET['id']) ? $_GET['id'] : null;
    // Instancia la clase manejoProducto
    $manejoProducto = new manejoProducto();
    // Llama al método eliminarProducto con el ID del producto
    $resultado = $manejoProducto->ocultar($idProducto);
    // Devuelve la respuesta como JSON
    echo json_encode($resultado);
    // Detén la ejecución del script
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Obten el ID del producto desde la URL
    $idProducto = isset($_GET['id']) ? $_GET['id'] : null;
    // Instancia la clase manejoProducto
    $manejoProducto = new manejoProducto();
    // Llama al método eliminarProducto con el ID del producto
    $resultado = $manejoProducto->eliminarProducto($idProducto);
    // Devuelve la respuesta como JSON
    echo json_encode($resultado);
    // Detén la ejecución del script
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'EDIT') {
    // Obten el ID del producto desde la URL
    $idProducto = isset($_GET['id']) ? $_GET['id'] : null;
    
    // Obtén los datos del producto desde la solicitud
    $datosProducto = file_get_contents('php://input');
    
    // Instancia la clase manejoProducto
    $manejoProducto = new manejoProducto();
    
    // Llama al método editarProducto con el ID del producto y los datos del producto
    $resultado = $manejoProducto->editarProducto($idProducto, $datosProducto);
    
    // Devuelve la respuesta como JSON
    echo json_encode($resultado);
    
    // Detén la ejecución del script
    exit();
}




$manejoProducto = new manejoProducto();

// Llama a la función ocultar con un ID de producto predeterminado
$idProducto = 71; // ID del producto que deseas ocultar
$resultado = $manejoProducto->ocultar($idProducto);

// Imprime el resultado
echo json_encode($resultado);