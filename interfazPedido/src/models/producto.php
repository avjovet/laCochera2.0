<?php

class Producto {
    private $conn;
    private $table_name = "producto";

    public $idProducto;
    public $nombre;
    public $precio;
    public $imagen;
    public $categoria;
    public $Estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para listar todos los productos
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function listarNoOcultos() {
        $query = "SELECT idProducto,nombre,precio,imagen,categoria FROM " . $this->table_name . " WHERE Estado = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    

    // Método para obtener un producto por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idProducto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear un nuevo producto
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, precio, imagen, categoria) VALUES (:nombre, :precio, :imagen, :categoria)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":imagen", $this->imagen);
        $stmt->bindParam(":categoria", $this->categoria);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
     
     public function ocultar() {
        // Obtener el valor actual de Estado
        $query = "SELECT Estado FROM " . $this->table_name . " WHERE idProducto = :idProducto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idProducto", $this->idProducto);
        $stmt->execute();
        $currentEstado = $stmt->fetch(PDO::FETCH_ASSOC)['Estado'];

        // Alternar el valor de Estado
        $newEstado = ($currentEstado == 1) ? 0 : 1;

        // Actualizar el valor de Estado
        $query = "UPDATE " . $this->table_name . " SET Estado = :Estado WHERE idProducto = :idProducto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Estado", $newEstado);
        $stmt->bindParam(":idProducto", $this->idProducto);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Método para actualizar un producto existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, precio = :precio, imagen = :imagen, categoria = :categoria WHERE idProducto = :idProducto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":imagen", $this->imagen);
        $stmt->bindParam(":categoria", $this->categoria);
        $stmt->bindParam(":idProducto", $this->idProducto);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un producto
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idProducto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idProducto);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
