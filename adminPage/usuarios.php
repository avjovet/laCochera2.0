<?php
// Incluir el archivo funciones.php que contiene la función obtenerPlatos() y la conexión $pdo

require_once '..\src\controllers\usuarioController.php';

// Crear una instancia de ProductoController
$UsuarioController = new UsuarioController();

// Llamar a la función obtenerProductosJSON()
$UsuarioController->obtenerUsuarioJSON();   