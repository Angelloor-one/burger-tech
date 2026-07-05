<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Tech - Categorías</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="nav-links">
    <a href="index.php?controlador=productos&accion=listar">🍔 Gestionar Productos</a>
    <a href="index.php?controlador=categorias&accion=listar" class="active">📂 Gestionar Categorías</a>
    <a href="index.php?controlador=usuarios&accion=listar">👥 Gestionar Personal</a>
    <a href="index.php?controlador=pedidos&accion=listar">🧾 Comandas / Pedidos</a>
</div>

<div class="container">
    <h1>📂 Panel de Categorías (Entidad Relacionada)</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Categoría</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categorias)): ?>
                <?php foreach ($categorias as $cat): ?>
                    <tr>
                        <td><?php echo $cat['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($cat['nombre']); ?></strong></td>
                        <td><?php echo htmlspecialchars($cat['descripcion']); ?></td>
                        <td>
                            <a href="index.php?controlador=categorias&accion=eliminar&id=<?php echo $cat['id']; ?>" 
                               class="btn" style="background-color: #dc3545; padding: 5px 10px; font-size: 0.85rem;"
                               onclick="return confirm('¿Seguro que deseas eliminar esta categoría? Se borrarán automáticamente todos los productos asociados a ella.');">
                               Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No hay categorías registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="form-inline">
        <h3>➕ Agregar Nueva Categoría</h3>
        <form id="categoryForm" action="index.php?controlador=categorias&accion=guardar" method="POST">
            
            <div class="form-group">
                <label for="cat_nombre">Nombre de la Categoría:</label>
                <input type="text" id="cat_nombre" name="nombre" placeholder="Ej: Acompañantes, Postres...">
                <div id="error-cat" class="error">El nombre es obligatorio y debe tener al menos 3 letras.</div>
            </div>
            
            <div class="form-group">
                <label for="cat_descripcion">Descripción opcional:</label>
                <input type="text" id="cat_descripcion" name="descripcion" placeholder="Breve detalle de los ítems de esta categoría">
            </div>
            
            <button type="submit" class="btn">Guardar Categoría</button>
        </form>
    </div>
</div>

<script>
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const nombre = document.getElementById('cat_nombre').value.trim();
    const errorDiv = document.getElementById('error-cat');
    
    if (nombre.length < 3) {
        errorDiv.style.display = 'block';
        e.preventDefault(); // Bloquear el envío del formulario si no es válido
    } else {
        errorDiv.style.display = 'none';
    }
});
</script>

</body>
</html>