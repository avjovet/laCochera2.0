<?php
// se obtiene un JSON con todos los productos de la base de datos.
require_once '../src/controllers/producto_controller.php';

$productoController = new ProductoController();

$productoController->obtenerProductosJSON2();

