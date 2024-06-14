<?php
// Incluir el archivo funciones.php que contiene la función obtenerPlatos() y la conexión $pdo

require_once '..\src\controllers\clientesController.php';

// Crear una instancia de ProductoController
$clienteController = new ClienteController();

// Llamar a la función obtenerProductosJSON()
$clienteController->obtenerClienteJSON();
