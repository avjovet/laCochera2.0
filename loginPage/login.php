<?php

include_once '../src/config/conection.php';
include_once '../src/controllers/logincontroller.php';

session_start();

if (isset($_GET['cerrar_sesion'])) {
    session_unset();
    session_destroy();
}

if (isset($_SESSION['rol'])) {
    switch ($_SESSION['rol']) {
        case 1:
            header('location: ../adminPage/adminPanel.php');
            break;
        case 2:
            header('location: mozo.php');
            break;
        case 3:
            header('location: cocina.php');
            break;
    }
}

if (isset($_POST['username']) && isset($_POST['password'])) {


    $username = $_POST['username'];
    $password = $_POST['password'];



    $db = new Database();
    $conn = $db->getConnection();
    $lc = new UsuarioLogin();
    $isusuario = $lc->autenticarUsuario2($username,$password);

    if($isusuario['success']){
        
        $_SESSION['rol'] = $isusuario['TipoUsuario_id'];

        if (isset($_SESSION['rol'])) {
            switch ($_SESSION['rol']) {
                case 1:
                    header('location: ../adminPage/adminPanel.php');
                    break;
                case 2:
                    header('location: mozo.php');
                    break;
                case 3:
                    header('location: cocina.php');
                    break;
            }
        }



    }else{

        echo "contraseña incorrecta";
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login | Ludiflex</title>
</head>
<body>
    <div class="login-box">
        <div class="login-header">
            <header>Login</header>
        </div>
        <form action="" method="POST">
            <div class="input-box">
                <input id="username" type="text" name="username" class="input-field" placeholder="Usuario" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input id="password" type="password" name="password" class="input-field" placeholder="Contraseña" autocomplete="off" required>
            </div>
            <div class="input-submit">
                <button class="submit-btn" type="submit">Ingresar</button>
            </div>
        </form>
    </div>
</body>
</html>
