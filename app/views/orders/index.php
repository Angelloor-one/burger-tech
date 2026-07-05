<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Tech - Comandas y Pedidos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<!-- Barra de Navegación del Sistema -->
<div class="nav-links">
    <a href="index.php?controlador=productos&accion=listar">🍔 Gestionar Productos</a>
    <a href="index.php?controlador=categorias&accion=listar">📂 Gestionar Categorías</a>
    <a href="index.php?controlador=usuarios&accion=listar">👥 Gestionar Personal</a>
    <a href="index.php?controlador=pedidos&accion=listar" class="active">🧾 Comandas / Pedidos</a>
</div>

<div class="container">
    <h1>🧾 Historial de Ventas e Ingresos (Entidad Pedidos)</h1>

    <table>
        <thead>
            <tr>
                <th>N° Pedido</th>
                <th>Producto solicitado</th>
                <th>Atendido por</th>
                <th>Cantidad</th>
                <th>Total Facturado</th>
                <th>Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pedidos)): ?>
                <?php foreach ($pedidos as $ped): ?>
                    <tr>
                        <td>#00<?php echo $ped['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($ped['producto_name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($ped['usuario_name']); ?></td>
                        <td><?php echo $ped['cantidad']; ?> unds.</td>
                        <td><span class="badge badge-success" style="font-size: 0.95rem;">$<?php echo number_format($ped['total'], 2); ?></span></td>
                        <td><small><?php echo $ped['fecha']; ?></small></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No se han registrado ventas el día de hoy.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Formulario Integrado para Generar Nueva Venta -->
    <div class="form-inline">
        <h3>➕ Registrar Nueva Venta / Comanda</h3>
        <form id="orderForm" action="index.php?controlador=pedidos&accion=guardar" method="POST">
            
            <div class="form-group">
                <label for="ped_producto">Selecciona el Producto:</label>
                <select id="ped_producto" name="producto_id">
                    <option value="">-- ¿Qué va a llevar el cliente? --</option>
                    <?php foreach ($productos as $p): ?>
                        <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['nombre']); ?> ($<?php echo $p['precio']; ?>)</option>
                    <?php endforeach; ?>
                </select>
                <div id="error-prod" class="error">Debe seleccionar un producto del menú.</div>
            </div>

            <div class="form-group">
                <label for="ped_usuario">Personal que atiende:</label>
                <select id="ped_usuario" name="usuario_id">
                    <option value="">-- Empleado en caja --</option>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['nombre']); ?> (<?php echo $u['rol']; ?>)</option>
                    <?php endforeach; ?>
                </select>
                <div id="error-user" class="error">Debe asignar el empleado responsable.</div>
            </div>

            <div class="form-group">
                <label for="ped_cantidad">Cantidad de unidades:</label>
                <input type="number" id="ped_cantidad" name="cantidad" min="1" value="1" placeholder="Ej: 2">
                <div id="error-cant" class="error">La cantidad mínima debe ser 1 unidad.</div>
            </div>
            
            <button type="submit" class="btn" style="background-color: #ffc107; color: #212529;">🔥 Procesar Orden y Cobrar</button>
        </form>
    </div>
</div>

<!-- VALIDACIÓN DE FRONTEND (JAVASCRIPT) -->
<script>
document.getElementById('orderForm').addEventListener('submit', function(e) {
    let isValid = true;
    document.querySelectorAll('.error').forEach(el => el.style.display = 'none');

    if (document.getElementById('ped_producto').value === "") {
        document.getElementById('error-prod').style.display = 'block';
        isValid = false;
    }

    if (document.getElementById('ped_usuario').value === "") {
        document.getElementById('error-user').style.display = 'block';
        isValid = false;
    }

    const cantidad = parseInt(document.getElementById('ped_cantidad').value);
    if (isNaN(cantidad) || cantidad <= 0) {
        document.getElementById('error-cant').style.display = 'block';
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
    }
});
</script>

</body>
</html>