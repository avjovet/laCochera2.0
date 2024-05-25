<?php

class MedioPago {
    private $conn;
    private $table_name = "mediopago";

    public $idMedioPago;
    public $MedioPago;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para listar todos los medios de pago
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para obtener un medio de pago por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idMedioPago = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear un nuevo medio de pago
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (MedioPago) VALUES (:MedioPago)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":MedioPago", $this->MedioPago);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para actualizar un medio de pago existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET MedioPago = :MedioPago WHERE idMedioPago = :idMedioPago";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":MedioPago", $this->MedioPago);
        $stmt->bindParam(":idMedioPago", $this->idMedioPago);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un medio de pago
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idMedioPago = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idMedioPago);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
