<?php
// Incluir el archivo funciones.php que contiene la función obtenerPlatos() y la conexión $pdo

require_once '../src/controllers/pedidoController.php';

// Crear una instancia de ProductoController
$pedidoController = new PedidoController();

// Llamar a la función obtenerProductosJSON()
$pedidoController->obtenerPedidoJSON();
