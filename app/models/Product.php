<?php
// Archivo: app/models/Product.php

class Product {
    private $conn;
    private $table_name = "productos";

    public $id;
    public $categoria_id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $disponible;
    public $categoria_nombre;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Consulta para LEER todos los productos
    public function readAll() {
        $query = "SELECT p.*, c.nombre as categoria_nombre 
                  FROM " . $this->table_name . " p 
                  INNER JOIN categorias c ON p.categoria_id = c.id 
                  ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    // Método para CREAR (Insertar) un producto nuevo
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET categoria_id=:categoria_id, nombre=:nombre, precio=:precio, descripcion=:descripcion, disponible=:disponible";

        $stmt = $this->conn->prepare($query);

        // Limpiar datos contra etiquetas maliciosas (Sanitización)
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
        $this->disponible = htmlspecialchars(strip_tags($this->disponible));

        // Vincular los parámetros de la consulta SQL
        $stmt->bindParam(":categoria_id", $this->categoria_id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":disponible", $this->disponible);

        // Ejecutar la consulta
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    // Método para ELIMINAR un producto por su ID
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar el ID
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Vincular el parámetro
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    // Método para BUSCAR un solo producto por su ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para ACTUALIZAR los datos en la BD
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET categoria_id = :categoria_id, nombre = :nombre, precio = :precio, descripcion = :descripcion, disponible = :disponible 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
        $this->disponible = htmlspecialchars(strip_tags($this->disponible));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular
        $stmt->bindParam(":categoria_id", $this->categoria_id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":disponible", $this->disponible);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>