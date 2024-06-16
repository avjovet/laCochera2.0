<?php
class Pedido {
    private $conn;
    private $table_name = "pedido";

    public $idPedido;
    public $Estado;
    public $Fecha;
    public $Cliente_idCliente;
    public $Mesa_id;
    public $Usuario_id;
    public $TipoPedido_id;
    public $MedioPago_id;
    public $codTrans;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para listar todos los pedidos
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Método para obtener un pedido por ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idPedido = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear un nuevo pedido
    public function crear() {

        echo "---------------entrando a crear ----------------------------<br>";

            // Imprimir los valores que se van a insertar
        echo "Estado: " . $this->Estado . " (" . gettype($this->Estado) . ")<br>";
        echo "Fecha: " . $this->Fecha . " (" . gettype($this->Fecha) . ")<br>";
        echo "Cliente_idCliente: " . $this->Cliente_idCliente . " (" . gettype($this->Cliente_idCliente) . ")<br>";
        echo "Mesa_id: " . $this->Mesa_id . " (" . gettype($this->Mesa_id) . ")<br>";
        echo "Usuario_id: " . $this->Usuario_id . " (" . gettype($this->Usuario_id) . ")<br>";
        echo "TipoPedido_id: " . $this->TipoPedido_id . " (" . gettype($this->TipoPedido_id) . ")<br>";
        echo "MedioPago_id: " . $this->MedioPago_id . " (" . gettype($this->MedioPago_id) . ")<br>";
        echo "codTrans: " . $this->codTrans . " (" . gettype($this->codTrans) . ")<br>";
        echo "Tabla: " . $this->table_name . " (" . gettype($this->table_name) . ")<br>";





        $query = "INSERT INTO " . $this->table_name . " (Estado, Fecha, Cliente_idCliente, Mesa_id, Usuario_id, TipoPedido_id, MedioPago_id, codTrans) VALUES (:Estado, :Fecha, :Cliente_idCliente, :Mesa_id, :Usuario_id, :TipoPedido_id, :MedioPago_id, :codTrans)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Estado", $this->Estado);
        $stmt->bindParam(":Fecha", $this->Fecha);
        $stmt->bindParam(":Cliente_idCliente", $this->Cliente_idCliente);
        $stmt->bindParam(":Mesa_id", $this->Mesa_id);
        $stmt->bindParam(":Usuario_id", $this->Usuario_id);
        $stmt->bindParam(":TipoPedido_id", $this->TipoPedido_id);
        $stmt->bindParam(":MedioPago_id", $this->MedioPago_id);
        $stmt->bindParam(":codTrans", $this->codTrans);
        echo $this->table_name;

        if ($stmt->execute()) {
            echo "???????????????que paso aqui";

            return true;
        }
        return false;
    }

    // Método para actualizar un pedido existente
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET Estado = :Estado, Fecha = :Fecha, Cliente_idCliente = :Cliente_idCliente, Mesa_id = :Mesa_id, Usuario_id = :Usuario_id, TipoPedido_id = :TipoPedido_id, MedioPago_id = :MedioPago_id WHERE idPedido = :idPedido";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Estado", $this->Estado);
        $stmt->bindParam(":Fecha", $this->Fecha);
        $stmt->bindParam(":Cliente_idCliente", $this->Cliente_idCliente);
        $stmt->bindParam(":Mesa_id", $this->Mesa_id);
        $stmt->bindParam(":Usuario_id", $this->Usuario_id);
        $stmt->bindParam(":TipoPedido_id", $this->TipoPedido_id);
        $stmt->bindParam(":MedioPago_id", $this->MedioPago_id);
        $stmt->bindParam(":idPedido", $this->idPedido);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un pedido
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idPedido = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idPedido);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
