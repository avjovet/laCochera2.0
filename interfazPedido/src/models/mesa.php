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
    public $Llamado;

    public $Fechallamado;

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

    public function actualizarLlamado() {
        // Obtener el valor actual de Llamado
        $query = "SELECT Llamado FROM " . $this->table_name . " WHERE idMesa = :idMesa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idMesa", $this->idMesa);
        $stmt->execute();
        $currentEstado = $stmt->fetch(PDO::FETCH_ASSOC)['Llamado'];
    
        // Alternar el valor de Llamado
        $newLlamdo = 1;  // Se puede ajustar la lógica si deseas alternar entre 0 y 1
    
        // Obtener la fecha y hora actual y restar 7 horas
        $fechallamado = new DateTime();
        $fechallamado->modify('-7 hours');
        $fechallamado = $fechallamado->format('Y-m-d H:i:s');
    
        // Actualizar el valor de Llamado y Fechallamado
        $query = "UPDATE " . $this->table_name . " SET Llamado = :Llamado, Fechallamado = :Fechallamado WHERE idMesa = :idMesa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Llamado", $newLlamdo);
        $stmt->bindParam(":Fechallamado", $fechallamado);
        $stmt->bindParam(":idMesa", $this->idMesa);
    
        if ($stmt->execute()) {
            echo "yei";
            return true;
        }
        return false;
    }
    
    
    public function actualizarLlamado2() {


        $query = "SELECT Llamado FROM " . $this->table_name . " WHERE idMesa = :idMesa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idMesa", $this->idMesa);
        $stmt->execute();
        $currentEstado = $stmt->fetch(PDO::FETCH_ASSOC)['Llamado'];

        // Alternar el valor de Estado
        $newLlamdo = 0;

        // Actualizar el valor de Estado
        $query = "UPDATE " . $this->table_name . " SET Llamado = :Llamado WHERE idMesa = :idMesa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Llamado", $newLlamdo);
        $stmt->bindParam(":idMesa", $this->idMesa);

        if ($stmt->execute()) {
            echo ("yei");
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
