<?php
// Se obtiene un json con todos los productos de la BD

require_once '..\src\controllers\producto_controller.php';

$productoController = new ProductoController();

$productoController->obtenerProductosJSON2();

