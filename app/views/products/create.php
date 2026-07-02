<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Tech - Agregar Producto</title>
    <!-- Vinculación limpia al CSS Global -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<!-- Barra de Navegación -->
<div class="nav-links">
    <a href="index.php?controlador=productos&accion=listar" class="active">🍔 Gestionar Productos</a>
    <a href="index.php?controlador=categorias&accion=listar">📂 Gestionar Categorías</a>
</div>

<div class="container">
    <div style="max-width: 500px; margin: auto;">
        <h1>🍔 Agregar Nuevo Producto</h1>
        
        <form id="productForm" action="index.php?controlador=productos&accion=guardar" method="POST">
            
            <div class="form-group">
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ej: Tech Burger, Bacon Crispy...">
                <div id="error-nombre" class="error">El nombre es obligatorio (mínimo 3 caracteres).</div>
            </div>

            <div class="form-group">
                <label for="categoria_id">Categoría:</label>
                <select id="categoria_id" name="categoria_id">
                    <option value="">-- Seleccione una categoría --</option>
                    <option value="1">Hamburguesas</option>
                    <option value="2">Bebidas</option>
                </select>
                <div id="error-categoria" class="error">Debe seleccionar una categoría válida.</div>
            </div>

            <div class="form-group">
                <label for="precio">Precio ($):</label>
                <input type="number" id="precio" name="precio" step="0.01" placeholder="Ej: 5.50">
                <div id="error-precio" class="error">El precio debe ser un número mayor a 0.</div>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="3" placeholder="Detalla los ingredientes..."></textarea>
            </div>

            <button type="submit" class="btn">Guardar Producto</button>
            <a href="index.php?controlador=productos&accion=listar" class="btn" style="background-color: #6c757d; margin-top: 10px; display: block; text-align: center;">Cancelar</a>
        </form>
    </div>
</div>

<!-- VALIDACIÓN EN FRONTEND CON JAVASCRIPT -->
<script>
document.getElementById('productForm').addEventListener('submit', function(event) {
    let isValid = true;

    // Limpiar errores previos
    document.querySelectorAll('.error').forEach(el => el.style.display = 'none');

    // Validar Nombre
    const nombre = document.getElementById('nombre').value.trim();
    if (nombre.length < 3) {
        document.getElementById('error-nombre').style.display = 'block';
        isValid = false;
    }

    // Validar Categoría
    const categoria = document.getElementById('categoria_id').value;
    if (categoria === "") {
        document.getElementById('error-categoria').style.display = 'block';
        isValid = false;
    }

    // Validar Precio
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