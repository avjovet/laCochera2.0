<?php

$servername = "165.232.146.177";
$username = "dev_test3";
$password = "_Esis2024";
$dbname = "cocheradbultimate";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>




