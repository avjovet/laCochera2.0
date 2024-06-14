<?php
// 165.232.146.177 localhost
//   dev_test3     root
//   _Esis2024    
//   cocheradbultimate  cochera2      
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cochera2";

try {
    $cone = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $cone->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Conexion fallida: " . $e->getMessage();
}
?>
