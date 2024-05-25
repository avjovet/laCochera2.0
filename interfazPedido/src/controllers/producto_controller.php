
<?php
require_once(realpath(dirname(__FILE__) . '\..\config\conection.php'));
require_once(realpath(dirname(__FILE__) . '\..\models\producto.php'));


class ProductoController {
    private $db;
    private $producto;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
    }

    public function listarProductos() {
        $stmt = $this->producto->listar();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include_once '../views/producto/listar.php';
    }

    public function obtenerProductosJSON() {
        $stmt = $this->producto->listar();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($productos);
    }
}

