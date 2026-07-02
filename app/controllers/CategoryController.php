<?php
// Archivo: app/controllers/CategoryController.php

require_once '../app/config/Database.php';
require_once '../app/models/Category.php';

class CategoryController {
    private $db;
    private $category;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->category = new Category($this->db);
    }

    // Listar categorías
    public function index() {
        $stmt = $this->category->readAll();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once '../app/views/categories/index.php';
    }

    // Procesar guardado (Crear)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

            // Validación Backend
            if (empty($nombre) || strlen($nombre) < 3) {
                die("Error: El nombre de la categoría debe tener al menos 3 caracteres.");
            }

            $this->category->nombre = $nombre;
            $this->category->descripcion = $descripcion;

            if ($this->category->create()) {
                header("Location: index.php?controlador=categorias&accion=listar");
                exit();
            }
        }
    }

    // Procesar actualización (Editar)
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = isset($_POST['id']) ? trim($_POST['id']) : '';
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

            if (empty($id) || empty($nombre) || strlen($nombre) < 3) {
                die("Error: Datos inválidos para actualizar categoría.");
            }

            $this->category->id = $id;
            $this->category->nombre = $nombre;
            $this->category->descripcion = $descripcion;

            if ($this->category->update()) {
                header("Location: index.php?controlador=categorias&accion=listar");
                exit();
            }
        }
    }

    // Eliminar categoría
    public function delete($id) {
        if (!empty($id) && is_numeric($id)) {
            $this->category->id = $id;
            if ($this->category->delete()) {
                header("Location: index.php?controlador=categorias&accion=listar");
                exit();
            }
        }
    }
}
?>