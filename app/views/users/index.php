<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Tech - Personal</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<!-- Barra de Navegación del Sistema -->
<div class="nav-links">
    <a href="index.php?controlador=productos&accion=listar">🍔 Gestionar Productos</a>
    <a href="index.php?controlador=categorias&accion=listar">📂 Gestionar Categorías</a>
    <a href="index.php?controlador=usuarios&accion=listar" class="active">👥 Gestionar Personal</a>
    <a href="index.php?controlador=pedidos&accion=listar">🧾 Comandas / Pedidos</a>
</div>

<div class="container">
    <h1>👥 Panel de Personal (Entidad Usuarios)</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Rol / Puesto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($user['nombre']); ?></strong></td>
                        <td><?php echo htmlspecialchars($user['correo']); ?></td>
                        <td>
                            <span class="badge <?php echo ($user['rol'] == 'admin') ? 'badge-success' : 'badge-danger'; ?>">
                                <?php echo htmlspecialchars($user['rol']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?controlador=usuarios&accion=eliminar&id=<?php echo $user['id']; ?>" 
                               class="btn" style="background-color: #dc3545; padding: 5px 10px; font-size: 0.85rem;"
                               onclick="return confirm('¿Seguro que deseas dar de baja a este usuario?');">
                               Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No hay personal registrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Formulario Integrado para Crear Usuarios -->
    <div class="form-inline">
        <h3>➕ Registrar Nuevo Miembro del Personal</h3>
        <form id="userForm" action="index.php?controlador=usuarios&accion=guardar" method="POST">
            
            <div class="form-group">
                <label for="usr_nombre">Nombre Completo:</label>
                <input type="text" id="usr_nombre" name="nombre" placeholder="Ej: Juan Pérez">
                <div id="error-name" class="error">El nombre es requerido (mínimo 3 letras).</div>
            </div>

            <div class="form-group">
                <label for="usr_correo">Correo Corporativo:</label>
                <input type="text" id="usr_correo" name="correo" placeholder="Ej: juan@burgertech.com">
                <div id="error-email" class="error">Escribe un correo electrónico válido.</div>
            </div>

            <div class="form-group">
                <label for="usr_password">Contraseña de Acceso:</label>
                <input type="password" id="usr_password" name="password" style="width: 100%; padding: 10px 14px; border: 1px solid #ced4da; border-radius: 6px;" placeholder="Asigna una clave temporal">
                <div id="error-pass" class="error">La contraseña no puede estar vacía.</div>
            </div>

            <div class="form-group">
                <label for="usr_rol">Rol asignado:</label>
                <select id="usr_rol" name="rol">
                    <option value="empleado">Empleado / Cajero</option>
                    <option value="admin">Administrador del Sistema</option>
                </select>
            </div>
            
            <button type="submit" class="btn">Guardar Usuario</button>
        </form>
    </div>
</div>

<!-- VALIDACIÓN DE FRONTEND (JAVASCRIPT) -->
<script>
document.getElementById('userForm').addEventListener('submit', function(e) {
    let isValid = true;
    document.querySelectorAll('.error').forEach(el => el.style.display = 'none');

    const nombre = document.getElementById('usr_nombre').value.trim();
    if (nombre.length < 3) {
        document.getElementById('error-name').style.display = 'block';
        isValid = false;
    }

    const correo = document.getElementById('usr_correo').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correo)) {
        document.getElementById('error-email').style.display = 'block';
        isValid = false;
    }

    const password = document.getElementById('usr_password').value.trim();
    if (password === "") {
        document.getElementById('error-pass').style.display = 'block';
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
    }
});
</script>

</body>
</html>