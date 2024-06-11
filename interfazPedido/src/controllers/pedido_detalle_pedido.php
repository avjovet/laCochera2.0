<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(realpath(dirname(__FILE__) . '/../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../models/pedido.php'));
require_once(realpath(dirname(__FILE__) . '/../models/detallepedido.php'));

header('Content-Type: application/json');

class InsertarPedido {
    private $db;
    private $pedido;
    private $detallepedido;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->pedido = new Pedido($this->db);
        $this->detallepedido = new DetallePedido($this->db);
    }

    public function insertarPedido($ArreglopedidoJson) {
        $pedidoData = json_decode($ArreglopedidoJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'JSON inválido: ' . json_last_error_msg()
            ];
        }

        $this->pedido->Estado = $pedidoData['Estado'];
        $this->pedido->Fecha = $pedidoData['Fecha'];
        $this->pedido->Cliente_idCliente = $pedidoData['Cliente_idCliente'];
        $this->pedido->Mesa_id = $pedidoData['Mesa_id'];
        $this->pedido->Usuario_id = $pedidoData['Usuario_id'];
        $this->pedido->TipoPedido_id = $pedidoData['TipoPedido_id'];
        $this->pedido->MedioPago_id = $pedidoData['MedioPago_id'];

        if ($this->pedido->crear()) {
            $idPedido = $this->db->lastInsertId();

            foreach ($pedidoData['detalles'] as $detalle) {
                $this->detallepedido->Fecha = $detalle['Fecha'];
                $this->detallepedido->Precio = $detalle['Precio'];
                $this->detallepedido->Cantidad = $detalle['Cantidad'];
                $this->detallepedido->NotaPedido = $detalle['NotaPedido'];
                $this->detallepedido->Producto_id = $detalle['Producto_id'];
                $this->detallepedido->Pedido_id = $idPedido;
                $this->detallepedido->insertar();
            }

            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error al crear el pedido'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $insertarPedido = new InsertarPedido();
    $resultado = $insertarPedido->insertarPedido($input);

    echo json_encode($resultado);
}

/*
$insertarPedido = new InsertarPedido();
$pedidoJson = '{"Estado":1,"Fecha":"2024-05-17","Cliente_idCliente":1,"Mesa_id":1,"Usuario_id":1,"TipoPedido_id":11,"MedioPago_id":1,"detalles":[{"Fecha":"2024-05-17","Precio":10,"Cantidad":2,"NotaPedido":"Sin notas","Producto_id":1},{"Fecha":"2024-05-17","Precio":5,"Cantidad":1,"NotaPedido":"Sin notas","Producto_id":2}]}';

$pedidoJson2 = '{"Estado":1,"Fecha":"2024-06-08 09:11:50","FechaAprobacion":null,"Cliente_idCliente":null,"Mesa_id":null,"Usuario_id":null,"TipoPedido_id":1,"MedioPago_id":null,"fechaCocinando":null,"fechaTerminado":null,"detalles":[{"Fecha":"2024-06-08 09:11:50","Precio":11,"Cantidad":1,"NotaPedido":"","Producto_id":4},{"Fecha":"2024-06-08 09:11:50","Precio":13,"Cantidad":1,"NotaPedido":"","Producto_id":2}]}';

$resultado = $insertarPedido->insertarPedido($pedidoJson2);
echo "Resultado de la inserción: ";
var_dump($resultado);*/