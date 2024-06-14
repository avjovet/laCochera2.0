
<?php
require_once(realpath(dirname(__FILE__) . '\..\config\conection.php'));
require_once(realpath(dirname(__FILE__) . '\..\models\pedido.php'));


class PedidoController { 
    private $db;
    private $pedido;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->pedido = new Pedido($this->db);
    }


    public function obtenerPedidoJSON() {
        $stmt = $this->pedido->listar();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($pedidos);
    }


}

