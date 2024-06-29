
<?php
require_once(realpath(dirname(__FILE__) . '/../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../models/categoriaproducto.php'));


class CategoriaController { 
    private $db;
    private $categoria;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->categoria = new CategoriaProducto($this->db);
    }


    public function obtenerCategoriaJSON() {
        $stmt = $this->categoria->listar();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($categorias);
    }


}

