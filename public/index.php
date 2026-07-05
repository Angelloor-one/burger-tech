<?php
// Archivo: public/index.php

// 1. Importaciones de los controladores
require_once '../app/controllers/ProductController.php';
require_once '../app/controllers/CategoryController.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/OrderController.php';

// 2. Captura de parámetros (Por defecto 'productos' si la URL está vacía)
$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : 'productos';
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'listar';
$id = isset($_GET['id']) ? $_GET['id'] : null;

// 3. Enrutamiento con prioridad estricta
if ($controlador == 'productos') {
    $controller = new ProductController();
    switch ($accion) {
        case 'listar': $controller->index(); break;
        case 'nuevo': $controller->create(); break;
        case 'guardar': $controller->store(); break;
        case 'editar': $controller->edit($id); break;
        case 'actualizar': $controller->update(); break;
        case 'eliminar': $controller->delete($id); break;
        default: $controller->index(); break;
    }
} 
elseif ($controlador == 'categorias') {
    $catController = new CategoryController();
    switch ($accion) {
        case 'listar': $catController->index(); break;
        case 'guardar': $catController->store(); break;
        case 'eliminar': $catController->delete($id); break;
        default: $catController->index(); break;
    }
}
elseif ($controlador == 'usuarios') {
    $userController = new UserController();
    switch ($accion) {
        case 'listar': $userController->index(); break;
        case 'guardar': $userController->store(); break;
        case 'eliminar': $userController->delete($id); break;
        default: $userController->index(); break;
    }
}
elseif ($controlador == 'pedidos') {
    $orderController = new OrderController();
    switch ($accion) {
        case 'listar': $orderController->index(); break;
        case 'guardar': $orderController->store(); break;
        default: $orderController->index(); break;
    }
}
else {
    // Si meten cualquier otra cosa en la URL, los manda a productos
    $controller = new ProductController();
    $controller->index();
}
?>