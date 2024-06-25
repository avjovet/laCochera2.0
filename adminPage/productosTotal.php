<?php
// Incluir el archivo funciones.php que contiene la función obtenerPlatos() y la conexión $pdo

require_once '../src/controllers/producto_controller.php';

// Crear una instancia de ProductoController
$productoController = new ProductoController();

// Llamar a la función obtenerProductosJSON()
$productoController->obtenerProductosJSON();

