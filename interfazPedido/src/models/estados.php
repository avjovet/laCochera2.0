<?php

class DetallePedido {
    private $conn;
    private $table_name = "estados";

    public $idStatus;
    public $nombre;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para insertar un nuevo detalle de pedido
    public function insertar() {
        $query = "INSERT INTO " . $this->table_name . " (nombre) VALUES (:nombre)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para actualizar un detalle de pedido existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . "SET nombre = :nombre";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
       

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un detalle de pedido
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idDetallePedido = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idStatus);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
