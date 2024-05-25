<?php

class TipoUsuario {
    private $conn;
    private $table_name = "tipousuario";

    public $idTipo;
    public $TipoUsu;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para listar todos los tipos de usuario
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para obtener un tipo de usuario por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idTipo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear un nuevo tipo de usuario
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (TipoUsu) VALUES (:TipoUsu)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":TipoUsu", $this->TipoUsu);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para actualizar un tipo de usuario existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET TipoUsu = :TipoUsu WHERE idTipo = :idTipo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":TipoUsu", $this->TipoUsu);
        $stmt->bindParam(":idTipo", $this->idTipo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un tipo de usuario
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idTipo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idTipo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
