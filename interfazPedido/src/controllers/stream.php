<?php

require_once(realpath(dirname(__FILE__) . 'pedido_detalle_pedido.php'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $insertarPedido = new InsertarPedido();
    $resultado = $insertarPedido->insertarPedido($input);

    echo json_encode([
        'success' => $resultado
    ]);
}

