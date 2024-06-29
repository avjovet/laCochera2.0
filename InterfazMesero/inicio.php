<?php
include 'conn/conn.php'; // Incluir el archivo de conexión


    // Iniciar el documento HTML
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<meta http-equiv="X-UA-Compatible" content="ie=edge">';
    echo '<title>Tabla de Pedidos</title>';
    echo '<link rel="stylesheet" type="text/css" href="F.css">';
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">';
    echo '</head>';
    echo '<body>';
    include 'sidebar.php';
    
    echo '<section class="home-section">';
    echo '<div class="container">';
    echo '<table class="table">';
    echo '<caption>Hola Mundo</caption>';
    echo '</table>';
    echo '</div>';
    echo '</section>'; 
    echo '</body>';
    echo '</html>';
// Cerrar la conexión
$conn = null;
?>
