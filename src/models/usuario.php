<?php

class Usuario {
    private $conn;
    private $table_name = "usuario";

    public $idUsuario;
    public $Usua;
    public $Contraseña;
    public $Nombre;
    public $TipoUsuario_id;
    public $logUsuario;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        $query = "SELECT idUsuario, Usua, Nombre, TipoUsuario_id FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorUsuario($usua) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Usua = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $usua);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear() {
        // Construir la consulta SQL con los valores sustituidos
        $query = "INSERT INTO " . $this->table_name . " (Usua, Contraseña, Nombre, TipoUsuario_id) VALUES ('" . $this->Usua . "', '" . $this->Contraseña . "', '" . $this->Nombre . "', " . $this->TipoUsuario_id . ")";
    
        // Imprimir la consulta SQL completa y lista para copiar
        echo "Consulta SQL para copiar y pegar en MySQL: <br>";
        echo $query . ";<br>";
    
        $stmt = $this->conn->prepare($query);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    

    public function actualizar() {
        // Construir la consulta SQL con los valores sustituidos
        $query = "UPDATE " . $this->table_name . " 
                  SET Usua = '" . $this->Usua . "', 
                      Contraseña = '" . $this->Contraseña . "', 
                      Nombre = '" . $this->Nombre . "', 
                      TipoUsuario_id = " . $this->TipoUsuario_id . " 
                  WHERE idUsuario = " . $this->idUsuario;
    
        // Imprimir la consulta SQL completa y lista para copiar
        echo "Consulta SQL para copiar y pegar en MySQL: <br>";
        echo $query . ";<br>";
    
        $stmt = $this->conn->prepare($query);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    

    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idUsuario);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }



    public function actualizarLogUsuario() {
        $query = "UPDATE " . $this->table_name . " SET logUsuario = :logUsuario WHERE idUsuario = :idUsuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':logUsuario', $this->logUsuario);
        $stmt->bindParam(':idUsuario', $this->idUsuario);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
