<?php

class CodQR {
    private $conn;
    private $table_name = "codqr";

    public $idCodqr;
    public $Codqrcol;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener un registro por su ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idCodqr = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear un nuevo registro
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (Codqrcol) VALUES (:Codqrcol)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Codqrcol", $this->Codqrcol);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para actualizar un registro existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET Codqrcol = :Codqrcol WHERE idCodqr = :idCodqr";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Codqrcol", $this->Codqrcol);
        $stmt->bindParam(":idCodqr", $this->idCodqr);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un registro
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idCodqr = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idCodqr);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
