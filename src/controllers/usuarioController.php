
<?php
require_once(realpath(dirname(__FILE__) . '/../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../models/usuario.php'));


class UsuarioController { 
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }


    public function obtenerUsuarioJSON() {
        $stmt = $this->usuario->listar();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($usuarios);
    }


}

