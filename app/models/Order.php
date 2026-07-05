<?php
// Archivo: app/models/Order.php

class Order {
    private $conn;
    private $table_name = "pedidos";

    public $id;
    public $producto_id;
    public $usuario_id;
    public $cantidad;
    public $total;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Listar pedidos uniendo las tablas de Productos y Usuarios (Relación compleja)
    public function readAll() {
        $query = "SELECT p.id, pr.nombre AS producto_name, u.nombre AS usuario_name, p.cantidad, p.total, p.fecha 
                  FROM " . $this->table_name . " p
                  INNER JOIN productos pr ON p.producto_id = pr.id
                  INNER JOIN usuarios u ON p.usuario_id = u.id
                  ORDER BY p.id DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Registrar un nuevo pedido
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET producto_id=:producto_id, usuario_id=:usuario_id, cantidad=:cantidad, total=:total";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":producto_id", $this->producto_id);
        $stmt->bindParam(":usuario_id", $this->usuario_id);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":total", $this->total);

        return $stmt->execute();
    }
}
?>