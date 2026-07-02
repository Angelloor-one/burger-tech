<?php
// Archivo: public/index.php

require_once '../app/controllers/ProductController.php';
require_once '../app/controllers/CategoryController.php';

// Detectar qué controlador quiere usar el usuario (por defecto 'productos')
$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : 'productos';
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'listar';
$id = isset($_GET['id']) ? $_GET['id'] : null;

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
?>