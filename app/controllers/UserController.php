<?php
// Archivo: app/controllers/UserController.php

require_once '../app/config/Database.php';
require_once '../app/models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // Listar todos los usuarios
    public function index() {
        $stmt = $this->user->readAll();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once '../app/views/users/index.php';
    }

    // Procesar el registro de un nuevo usuario
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $rol = isset($_POST['rol']) ? trim($_POST['rol']) : 'empleado';

            // Validación Backend básica
            if (empty($nombre) || strlen($nombre) < 3 || empty($correo) || empty($password)) {
                die("Error: Todos los campos son obligatorios y el nombre debe tener al menos 3 letras.");
            }

            $this->user->nombre = $nombre;
            $this->user->correo = $correo;
            $this->user->password = $password; // En texto plano por simplicidad de tus pruebas
            $this->user->rol = $rol;

            if ($this->user->create()) {
                header("Location: index.php?controlador=usuarios&accion=listar");
                exit();
            } else {
                echo "No se pudo registrar el usuario.";
            }
        }
    }

    // Eliminar un usuario
    public function delete($id) {
        if (!empty($id) && is_numeric($id)) {
            $this->user->id = $id;
            if ($this->user->delete()) {
                header("Location: index.php?controlador=usuarios&accion=listar");
                exit();
            }
        }
    }
}
?> 