<?php

class DetallePedido {
    private $conn;
    private $table_name = "detallepedido";

    public $idDetallePedido;
    public $Fecha;
    public $Precio;
    public $Cantidad;
    public $NotaPedido;
    public $Producto_id;
    public $Pedido_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para insertar un nuevo detalle de pedido
    public function insertar() {
        $query = "INSERT INTO " . $this->table_name . " (Fecha, Precio, Cantidad, NotaPedido, Producto_id, Pedido_id) VALUES (:Fecha, :Precio, :Cantidad, :NotaPedido, :Producto_id, :Pedido_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":Fecha", $this->Fecha);
        $stmt->bindParam(":Precio", $this->Precio);
        $stmt->bindParam(":Cantidad", $this->Cantidad);
        $stmt->bindParam(":NotaPedido", $this->NotaPedido);
        $stmt->bindParam(":Producto_id", $this->Producto_id);
        $stmt->bindParam(":Pedido_id", $this->Pedido_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para actualizar un detalle de pedido existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET Fecha = :Fecha, Precio = :Precio, Cantidad = :Cantidad, NotaPedido = :NotaPedido, Producto_id = :Producto_id, Pedido_id = :Pedido_id WHERE idDetallePedido = :idDetallePedido";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":Fecha", $this->Fecha);
        $stmt->bindParam(":Precio", $this->Precio);
        $stmt->bindParam(":Cantidad", $this->Cantidad);
        $stmt->bindParam(":NotaPedido", $this->NotaPedido);
        $stmt->bindParam(":Producto_id", $this->Producto_id);
        $stmt->bindParam(":Pedido_id", $this->Pedido_id);
        $stmt->bindParam(":idDetallePedido", $this->idDetallePedido);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un detalle de pedido
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idDetallePedido = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idDetallePedido);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
