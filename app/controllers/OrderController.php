<?php
// Archivo: app/controllers/OrderController.php

require_once '../app/config/Database.php';
require_once '../app/models/Order.php';
require_once '../app/models/Product.php';
require_once '../app/models/User.php';

class OrderController {
    private $db;
    private $order;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->order = new Order($this->db);
    }

    // Mostrar el historial de pedidos y cargar los selectores del formulario
    public function index() {
        $stmt = $this->order->readAll();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Necesitamos cargar los productos y usuarios para ponerlos en los combobox del formulario
        $productModel = new Product($this->db);
        $userModel = new User($this->db);

        $productos = $productModel->readAll()->fetchAll(PDO::FETCH_ASSOC);
        $usuarios = $userModel->readAll()->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/orders/index.php';
    }

    // Registrar venta calculando el total de forma segura en el backend
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $producto_id = isset($_POST['producto_id']) ? $_POST['producto_id'] : '';
            $usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : '';
            $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;

            if (empty($producto_id) || empty($usuario_id) || $cantidad <= 0) {
                die("Error: Datos de pedido inválidos.");
            }

            // Buscar el precio del producto para calcular el total real
            $productModel = new Product($this->db);
            $item = $productModel->readOne($producto_id);
            
            if (!$item) {
                die("Error: El producto seleccionado no existe.");
            }

            $precio_unitario = floatval($item['precio']);
            $total_calculado = $precio_unitario * $cantidad;

            $this->order->producto_id = $producto_id;
            $this->order->usuario_id = $usuario_id;
            $this->order->cantidad = $cantidad;
            $this->order->total = $total_calculado;

            if ($this->order->create()) {
                header("Location: index.php?controlador=pedidos&accion=listar");
                exit();
            }
        }
    }
}
?>