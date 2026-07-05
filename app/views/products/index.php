<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Tech - Administrador de Menú</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="nav-links">
    <a href="index.php?controlador=productos&accion=listar" class="active">🍔 Gestionar Productos</a>
    <a href="index.php?controlador=categorias&accion=listar">📂 Gestionar Categorías</a>
    <a href="index.php?controlador=usuarios&accion=listar">👥 Gestionar Personal</a>
    <a href="index.php?controlador=pedidos&accion=listar">🧾 Comandas / Pedidos</a>
</div>

<div class="container">
    <h1>🍔 Burger Tech - Panel de Productos</h1>
    
    <div style="margin-bottom: 20px;">
        <a href="index.php?controlador=productos&accion=nuevo" class="btn">+ Agregar Nuevo Producto (CRUD)</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $prod): ?>
                    <tr>
                        <td><?php echo $prod['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($prod['nombre']); ?></strong></td>
                        <td><?php echo htmlspecialchars($prod['categoria_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($prod['descripcion']); ?></td>
                        <td>$<?php echo number_format($prod['precio'], 2); ?></td>
                        <td>
                            <span class="badge <?php echo $prod['disponible'] ? 'badge-success' : 'badge-danger'; ?>">
                                <?php echo $prod['disponible'] ? 'Disponible' : 'Agotado'; ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?controlador=productos&accion=editar&id=<?php echo $prod['id']; ?>" class="btn btn-info" style="padding: 5px 10px; font-size: 0.85rem;">Editar</a>
                            
                            <a href="index.php?controlador=productos&accion=eliminar&id=<?php echo $prod['id']; ?>" class="btn" style="background-color: #dc3545; padding: 5px 10px; font-size: 0.85rem;" 
                               onclick="return confirm('¿Seguro que deseas eliminar esta hamburguesa?');">
                               Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay productos registrados en el menú.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>