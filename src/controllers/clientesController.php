
<?php
require_once(realpath(dirname(__FILE__) . '/../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../models/cliente.php'));


class ClienteController { 
    private $db;
    private $cliente;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cliente = new Cliente($this->db);
    }


    public function obtenerClienteJSON() {
        $stmt = $this->cliente->listar();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($categorias);
    }


}

