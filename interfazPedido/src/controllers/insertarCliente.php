<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(realpath(dirname(__FILE__) . '/../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../models/cliente.php'));

header('Content-Type: application/json');

class InsertarCliente {
    private $db;
    private $cliente;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cliente = new Cliente($this->db);
    }

    public function insertarCliente($ArregloClienteJson) {
        $clienteData = json_decode($ArregloClienteJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'JSON inválido: ' . json_last_error_msg()
            ];
        }

        $this->cliente->Nombre = $clienteData['Nombre'];
        $this->cliente->Direccion = $clienteData['Direccion'];
        $this->cliente->NumTelefono = $clienteData['NumTelefono'];

        $idCliente = $this->cliente->crear();
        

        if ($idCliente) {
            return [
                'success' => true,
                'idCliente' => $idCliente
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al crear el cliente'
            ];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $insertarCliente = new InsertarCliente();
    $resultado = $insertarCliente->insertarCliente($input);

    echo json_encode($resultado);
}
