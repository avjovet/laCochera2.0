<?php

class Mesa {
    private $conn;
    private $table_name = "mesa";

    public $idMesa;
    public $Estado;
    public $Numero;
    public $Codqr_id;
    public $Estado_Mesa_id;
    public $Codqr_idCodqr;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para listar todas las mesas
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para obtener una mesa por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idMesa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear una nueva mesa
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (Estado, Numero, Codqr_id, Estado_Mesa_id, Codqr_idCodqr) VALUES (:Estado, :Numero, :Codqr_id, :Estado_Mesa_id, :Codqr_idCodqr)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Estado", $this->Estado);
        $stmt->bindParam(":Numero", $this->Numero);
        $stmt->bindParam(":Codqr_id", $this->Codqr_id);
        $stmt->bindParam(":Estado_Mesa_id", $this->Estado_Mesa_id);
        $stmt->bindParam(":Codqr_idCodqr", $this->Codqr_idCodqr);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para actualizar una mesa existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET Estado = :Estado, Numero = :Numero, Codqr_id = :Codqr_id, Estado_Mesa_id = :Estado_Mesa_id, Codqr_idCodqr = :Codqr_idCodqr WHERE idMesa = :idMesa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Estado", $this->Estado);
        $stmt->bindParam(":Numero", $this->Numero);
        $stmt->bindParam(":Codqr_id", $this->Codqr_id);
        $stmt->bindParam(":Estado_Mesa_id", $this->Estado_Mesa_id);
        $stmt->bindParam(":Codqr_idCodqr", $this->Codqr_idCodqr);
        $stmt->bindParam(":idMesa", $this->idMesa);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar una mesa
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idMesa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idMesa);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
