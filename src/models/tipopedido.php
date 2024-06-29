<?php

class TipoPedido {
    private $conn;
    private $table_name = "tipopedido";

    public $idTipoPedido;
    public $TipoPed;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para listar todos los tipos de pedido
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para obtener un tipo de pedido por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idTipoPedido = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear un nuevo tipo de pedido
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (TipoPed) VALUES (:TipoPed)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":TipoPed", $this->TipoPed);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para actualizar un tipo de pedido existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET TipoPed = :TipoPed WHERE idTipoPedido = :idTipoPedido";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":TipoPed", $this->TipoPed);
        $stmt->bindParam(":idTipoPedido", $this->idTipoPedido);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un tipo de pedido
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idTipoPedido = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idTipoPedido);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
