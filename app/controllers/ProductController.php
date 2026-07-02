<?php
// Archivo: app/controllers/ProductController.php

require_once '../app/config/Database.php';
require_once '../app/models/Product.php';

class ProductController {
    private $db;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }

    // Listar todos los productos
    public function index() {
        $stmt = $this->product->readAll();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once '../app/views/products/index.php';
    }

    // Mostrar el formulario de creación
    public function create() {
        require_once '../app/views/products/create.php';
    }

    // Recibir los datos del formulario, validar en Backend y Guardar
    public function store() {
        // Verificar si se enviaron datos por POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // VALIDACIÓN EN BACKEND (PHP) - No permitir campos vacíos o inconsistentes
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $categoria_id = isset($_POST['categoria_id']) ? trim($_POST['categoria_id']) : '';
            $precio = isset($_POST['precio']) ? trim($_POST['precio']) : '';
            $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

            // Si falla una validación de PHP, detenemos el proceso (Seguridad del sistema)
            if (empty($nombre) || strlen($nombre) < 3 || empty($categoria_id) || empty($precio) || !is_numeric($precio) || $precio <= 0) {
                die("Error de validación en el servidor: Datos inválidos o vacíos.");
            }

            // Si pasa las validaciones, asignamos los valores al modelo
            $this->product->nombre = $nombre;
            $this->product->categoria_id = $categoria_id;
            $this->product->precio = $precio;
            $this->product->descripcion = $descripcion;
            $this->product->disponible = 1; // Por defecto disponible

            // Intentar guardar en la base de datos
            if ($this->product->create()) {
                // Redireccionar al panel principal si se guardó con éxito
                header("Location: index.php?accion=listar");
                exit();
            } else {
                echo "No se pudo registrar el producto debido a un problema interno.";
            }
        }
    }
    // Eliminar un producto
    public function delete($id) {
        if (!empty($id) && is_numeric($id)) {
            $this->product->id = $id;
            
            if ($this->product->delete()) {
                // Redireccionar al panel principal tras eliminar
                header("Location: index.php?accion=listar");
                exit();
            } else {
                echo "No se pudo eliminar el producto.";
            }
        } else {
            die("ID de producto inválido.");
        }
    }
    // Cargar el formulario de edición con los datos actuales
    public function edit($id) {
        if (!empty($id) && is_numeric($id)) {
            // Buscamos los datos de ese producto específico
            $producto = $this->product->readOne($id);
            if ($producto) {
                require_once '../app/views/products/edit.php';
            } else {
                echo "Producto no encontrado.";
            }
        }
    }

    // Procesar la actualización con validación backend
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = isset($_POST['id']) ? trim($_POST['id']) : '';
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $categoria_id = isset($_POST['categoria_id']) ? trim($_POST['categoria_id']) : '';
            $precio = isset($_POST['precio']) ? trim($_POST['precio']) : '';
            $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
            $disponible = isset($_POST['disponible']) ? trim($_POST['disponible']) : '';

            // Validación robusta Backend (PHP)
            if (empty($id) || empty($nombre) || strlen($nombre) < 3 || empty($precio) || $precio <= 0) {
                die("Error de validación en el servidor: Los datos editados son inválidos.");
            }

            // Asignar al modelo
            $this->product->id = $id;
            $this->product->nombre = $nombre;
            $this->product->categoria_id = $categoria_id;
            $this->product->precio = $precio;
            $this->product->descripcion = $descripcion;
            $this->product->disponible = $disponible;

            if ($this->product->update()) {
                header("Location: index.php?accion=listar");
                exit();
            } else {
                echo "No se pudieron guardar los cambios.";
            }
        }
    }
}
?>