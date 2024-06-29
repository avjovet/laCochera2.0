<?php

class CategoriaProducto {
    private $conn;
    private $table_name = "categoriaproducto";

    public $idCategoriaProducto;
    public $NombreCategoria;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para listar todas las categorías de productos
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para obtener una categoría de producto por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idCategoriaProducto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear una nueva categoría de producto
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (NombreCategoria) VALUES (:NombreCategoria)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":NombreCategoria", $this->NombreCategoria);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para actualizar una categoría de producto existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET NombreCategoria = :NombreCategoria WHERE idCategoriaProducto = :idCategoriaProducto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":NombreCategoria", $this->NombreCategoria);
        $stmt->bindParam(":idCategoriaProducto", $this->idCategoriaProducto);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar una categoría de producto
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idCategoriaProducto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idCategoriaProducto);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function ocultar() {
        // Obtener el valor actual de Estado
        $query = "SELECT Estado FROM " . $this->table_name . " WHERE idCategoriaProducto = :idCategoriaProducto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idCategoriaProducto", $this->idCategoriaProducto);
        $stmt->execute();
        $currentEstado = $stmt->fetch(PDO::FETCH_ASSOC)['Estado'];

        // Alternar el valor de Estado
        $newEstado = ($currentEstado == 1) ? 0 : 1;

        // Actualizar el valor de Estado
        $query = "UPDATE " . $this->table_name . " SET Estado = :Estado WHERE idCategoriaProducto = :idCategoriaProducto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Estado", $newEstado);
        $stmt->bindParam(":idCategoriaProducto", $this->idCategoriaProducto);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}


