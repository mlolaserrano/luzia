<?php 
session_start(); 
//conexón
include "connec.php";
$conn = conectarBDLuzia();
if (!$conn) {
    die("<h2 style='color:red'>Error: No se pudo conectar a la base de datos.</h2>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_pedido'])) {
    $id_borrar = (int)$_POST['borrar_pedido'];
    $stmt = $conn->prepare("DELETE FROM pedido WHERE id = ?");
    $stmt->bind_param("i", $id_borrar);
    $stmt->execute();

    if (isset($_SESSION['pedidos_estados'][$id_borrar])) {
        unset($_SESSION['pedidos_estados'][$id_borrar]);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_pedido_id'], $_POST['estado'])) {
    $id_pedido = (int)$_POST['update_pedido_id'];
    $nuevo_estado = $_POST['estado'];

    $opciones = ['Pendiente','En almacen','Transporte','Entregado'];
    if (!in_array($nuevo_estado, $opciones)) {
        $nuevo_estado = 'Pendiente';
    }

    $stmt = $conn->prepare("UPDATE pedido SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $nuevo_estado, $id_pedido);
    $stmt->execute();

    if (!isset($_SESSION['pedidos_estados'])) {
        $_SESSION['pedidos_estados'] = [];
    }
    $_SESSION['pedidos_estados'][$id_pedido] = $nuevo_estado;

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestión de Inventario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<link rel="stylesheet" href="style.css" />
<style>
.stock-alto td { background: rgba(198, 255, 214, 0.4); }
.stock-medio td { background: rgba(255, 243, 204, 0.4); }
.stock-bajo td { background: rgba(255, 228, 228, 0.4); }
</style>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
<div class="container-fluid position-relative">
<a class="navbar-brand navbar-brand-top" href="admi_home.html">LUZIA</a>
<button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuRight" aria-controls="menuRight" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse d-none d-lg-flex">
<div class="d-flex ms-lg-auto">
<a class="btn icon-btn" href="admi_productos.html" aria-label="Inventario"><i class="bi bi-gear"></i></a>
<a class="btn icon-btn" href="admi_home.html" aria-label="Vista"><i class="bi bi-eye"></i></a>
<a class="btn icon-btn" href="admi_logout.html" aria-label="Salir"><i class="bi bi-door-open"></i></a>
</div>
</div>
</div>
</nav>
<div class="offcanvas offcanvas-end" tabindex="-1" id="menuRight" aria-labelledby="menuRightLabel">
<div class="offcanvas-header justify-content-center">
<h5 class="offcanvas-title" id="menuRightLabel">LUZIA</h5>
<button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
<ul class="list-unstyled text-center w-100">
<li class="mb-3">
<a href="admi_productos.html" class="d-flex flex-column align-items-center text-decoration-none">
<i class="bi bi-gear"></i><span class="small mt-1">Productos</span>
</a>
</li>
<li class="mb-3">
<a href="admi_home.html" class="d-flex flex-column align-items-center text-decoration-none">
<i class="bi bi-eye fs-3"></i><span class="small mt-1">Vista</span>
</a>
</li>
<li>
<a href="admi_logout.html" class="d-flex flex-column align-items-center text-decoration-none">
<i class="bi bi-door-open fs-3"></i><span class="small mt-1">Salir</span>
</a>
</li>
</ul>
</div>
</div>
</header>

<main>
<div class="container mt-4">

<!-- Sección de Inventario -->
<section id="inventario">
<h2 class="section-title">Gestión de Inventario</h2>
<div class="table-responsive">
<table class="table table-striped table-hover">
<thead class="table-dark">
<tr>
<th class="text-dark">SKU</th>
<th class="text-dark">Producto</th>
<th class="text-dark">Categoría</th>
<th class="text-dark">Costo</th>
<th class="text-dark">Precio Venta</th>
<th class="text-dark">Stock</th>
</tr>
</thead>
<tbody>
<?php
$sql = "SELECT sku, nombre, categoria, precio, stock FROM producto";
$res = $conn->query($sql);
if ($res && $res->num_rows > 0) {
    while ($r = $res->fetch_assoc()) {
        $categoria = ucwords(mb_strtolower($r['categoria']));
        $costo = "—";
        $precio_fmt = '$' . number_format($r['precio'], 0, ',', '.');
        $stock = $r['stock'];
        echo "<tr>
        <td>{$r['sku']}</td>
        <td>{$r['nombre']}</td>
        <td>{$categoria}</td>
        <td>{$costo}</td>
        <td>{$precio_fmt}</td>
        <td>{$stock}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No hay productos cargados.</td></tr>";
}
?>
</tbody>
</table>
</div>
</section>

<!-- Sección de Ventas -->
<section id="ventas" class="mt-5">
<h2 class="section-title">Historial de Ventas</h2>
<div class="card">
<div class="card-header">
<h5 class="mb-0">Ventas Realizadas</h5>
</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>Fecha</th>
<th>Cliente</th>
<th>Cantidad</th>
<th>Estado</th>
<th>Total</th>
</tr>
</thead>
<tbody>
<?php
$sqlVentas = "SELECT p.id, p.fecha, u.email AS cliente, p.cantidad, p.estado, p.montobruto
FROM pedido p
LEFT JOIN usuario u ON p.id_usuario = u.id
ORDER BY p.fecha DESC";
$resV = $conn->query($sqlVentas);

if ($resV && $resV->num_rows > 0) {
    while ($v = $resV->fetch_assoc()) {
        $idPedido = (int)$v['id'];
        $fecha = htmlspecialchars($v['fecha']);
        $cliente = htmlspecialchars($v['cliente'] ?? '-');
        $cantidad = (int)($v['cantidad'] ?? 0);
        $estado_bd = htmlspecialchars($v['estado'] ?? 'Pendiente');
        $total = isset($v['montobruto']) ? '$'.number_format((float)$v['montobruto'],0,',','.') : '—';

        $estado_actual = $estado_bd;
        if (isset($_SESSION['pedidos_estados'][$idPedido])) {
            $estado_actual = $_SESSION['pedidos_estados'][$idPedido];
        }
        ?>
        <tr>
            <td><?php echo $fecha; ?></td>
            <td><?php echo $cliente; ?></td>
            <td><?php echo $cantidad; ?></td>
            <td>
                <div style="display:flex; gap:5px; align-items:center;">
                    <form action="" method="post" style="margin:0;">
                        <input type="hidden" name="update_pedido_id" value="<?php echo $idPedido; ?>">
                        <select name="estado">
                            <?php
                            $opciones = ['Pendiente','En almacen','Transporte','Entregado'];
                            foreach ($opciones as $op) {
                                $selected = ($estado_actual === $op) ? 'selected' : '';
                                echo "<option value='{$op}' {$selected}>{$op}</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                    </form>

                    <form action="" method="post" style="margin:0;">
                        <input type="hidden" name="borrar_pedido" value="<?php echo $idPedido; ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Desea borrar este pedido?');">Borrar</button>
                    </form>
                </div>
            </td>
            <td><?php echo $total; ?></td>
        </tr>
        <?php
    }
} else {
    echo "<tr><td colspan='5'>No hay ventas registradas.</td></tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>
</section>
</div>
</main>

<footer class="mt-5 text-center">
<p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
<div class="d-flex flex-wrap justify-content-center gap-3">
<a href="admi_politicas.html">Política de privacidad</a>
<a href="admi_terminos.html">Términos y condiciones</a>
<a href="admi_contacto.html">Contacto</a>
</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
