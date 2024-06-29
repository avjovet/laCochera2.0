<?php
// Incluir el archivo funciones.php que contiene la función obtenerPlatos() y la conexión $pdo

require_once '../src/controllers/categoria_controller.php';

// Crear una instancia de ProductoController
$CategoriaController = new CategoriaController();

// Llamar a la función obtenerProductosJSON()
$CategoriaController->obtenerCategoriaJSON();
