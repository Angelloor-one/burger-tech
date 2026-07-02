<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Tech - Editar Producto</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .form-container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #333; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        .btn-cancel { background-color: #6c757d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; display: block; text-align: center; margin-top: 10px; }
        .error-message { color: #dc3545; font-size: 14px; margin-top: 5px; display: none; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>🍔 Editar Producto</h2>
    
    <form id="editForm" action="index.php?accion=actualizar" method="POST">
        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
        
        <div class="form-group">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
            <div id="error-nombre" class="error-message">El nombre es obligatorio (mínimo 3 caracteres).</div>
        </div>

        <div class="form-group">
            <label for="categoria_id">Categoría:</label>
            <select id="categoria_id" name="categoria_id">
                <option value="1" <?php echo ($producto['categoria_id'] == 1) ? 'selected' : ''; ?>>Hamburguesas</option>
                <option value="2" <?php echo ($producto['categoria_id'] == 2) ? 'selected' : ''; ?>>Bebidas</option>
            </select>
        </div>

        <div class="form-group">
            <label for="precio">Precio ($):</label>
            <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>">
            <div id="error-precio" class="error-message">El precio debe ser un número mayor a 0.</div>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="3"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="disponible">Estado:</label>
            <select id="disponible" name="disponible">
                <option value="1" <?php echo ($producto['disponible'] == 1) ? 'selected' : ''; ?>>✅ Disponible</option>
                <option value="0" <?php echo ($producto['disponible'] == 0) ? 'selected' : ''; ?>>❌ Agotado</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">Guardar Cambios</button>
        <a href="index.php?accion=listar" class="btn-cancel">Cancelar</a>
    </form>
</div>

<script>
document.getElementById('editForm').addEventListener('submit', function(event) {
    let isValid = true;
    document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');

    const nombre = document.getElementById('nombre').value.trim();
    if (nombre.length < 3) {
        document.getElementById('error-nombre').style.display = 'block';
        isValid = false;
    }

    const precio = parseFloat(document.getElementById('precio').value);
    if (isNaN(precio) || precio <= 0) {
        document.getElementById('error-precio').style.display = 'block';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
    }
});
</script>

</body>
</html>