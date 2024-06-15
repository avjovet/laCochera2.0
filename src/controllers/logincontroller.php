<?php
require_once(realpath(dirname(__FILE__) . '/../config/conection.php'));
require_once(realpath(dirname(__FILE__) . '/../models/usuario.php'));

class UsuarioLogin {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function autenticarUsuario($jsonCredenciales) {
        $credenciales = json_decode($jsonCredenciales, true);

        if (!$credenciales) {
            return [
                'success' => false,
                'message' => 'Invalid JSON'
            ];
        }

        $usua = $credenciales['username'];
        $contraseña = $credenciales['password'];

        $usuarioData = $this->usuario->obtenerPorUsuario($usua);
        if ($usuarioData && password_verify($contraseña, $usuarioData['Contraseña'])) {
            $this->usuario->idUsuario = $usuarioData['idUsuario'];
            $this->usuario->logUsuario = 1;
            $this->usuario->actualizarLogUsuario();
            
            return [
                'success' => true,
                'idUsuario' => $this->usuario->idUsuario,
                'Nombre' => $usua,
                'TipoUsuario_id' => $usuarioData['TipoUsuario_id']
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Usuario o contraseña incorrectos'
            ];
        }
    }

    public function autenticarUsuario2($username, $password) {
        // Obtener los datos del usuario a partir del nombre de usuario
        $usuarioData = $this->usuario->obtenerPorUsuario($username);
    
        // Verificar si los datos del usuario fueron encontrados y si la contraseña es correcta
        if ($usuarioData && password_verify($password, $usuarioData['Contraseña'])) {
            // Actualizar el log del usuario
            $this->usuario->idUsuario = $usuarioData['idUsuario'];
            $this->usuario->logUsuario = 1;
            $this->usuario->actualizarLogUsuario();
    
            // Retornar respuesta de éxito
            return [
                'success' => true,
                'idUsuario' => $this->usuario->idUsuario,
                'Nombre' => $username,
                'TipoUsuario_id' => $usuarioData['TipoUsuario_id']
            ];
        } else {
            // Retornar respuesta de fracaso
            return [
                'success' => false,
            ];
        }
    }
}
/*
// Set the content type to JSON and handle any errors gracefully
header('Content-Type: application/json');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = file_get_contents('php://input');
        $usuarioLogin = new UsuarioLogin();
        $resultado = $usuarioLogin->autenticarUsuario($data);
        echo json_encode($resultado);
    } else {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

/*
$usua = '{"username":"UserAdmin","password":"UserAdmin"}';

$usuarioLogin = new UsuarioLogin();
$resultado = $usuarioLogin->autenticarUsuario($usua);
echo json_encode($resultado);*/