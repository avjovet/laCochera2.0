<?php

class Cliente {
    private $conn;
    private $table_name = "cliente";

    public $idCliente;
    public $Nombre;
    public $Direccion;
    public $NumTelefono;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para listar todos los clientes
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para obtener un cliente por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idCliente = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear un nuevo cliente
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (Nombre, Direccion, NumTelefono) VALUES (:Nombre, :Direccion, :NumTelefono)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Nombre", $this->Nombre);
        $stmt->bindParam(":Direccion", $this->Direccion);
        $stmt->bindParam(":NumTelefono", $this->NumTelefono);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para actualizar un cliente existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET Nombre = :Nombre, Direccion = :Direccion, NumTelefono = :NumTelefono WHERE idCliente = :idCliente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Nombre", $this->Nombre);
        $stmt->bindParam(":Direccion", $this->Direccion);
        $stmt->bindParam(":NumTelefono", $this->NumTelefono);
        $stmt->bindParam(":idCliente", $this->idCliente);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un cliente
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idCliente = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idCliente);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
