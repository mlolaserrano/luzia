<?php
// conexión
include "connec.php";
$conn = conectarBDLuzia();
if (!$conn) {
    die("<h2 style='color:red'>Error: No se pudo conectar a la base de datos.</h2>");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gestión de Inventario</title>
	<!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      crossorigin="anonymous"
    />
    <!-- Bootstrap Icons -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="style.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap" rel="stylesheet">
	<style>
	/* pequeños ajustes locales para asegurar colores de stock si no están en style.css */
	.stock-alto td { background: rgba(198, 255, 214, 0.4); }
	.stock-medio td { background: rgba(255, 243, 204, 0.4); }
	.stock-bajo td { background: rgba(255, 228, 228, 0.4); }
	</style>
</head>

<body>

    <!-- Navbar (idéntico al tuyo original) -->

  <header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid position-relative">
      <!-- Brand fijo centrado -->
      <a class="navbar-brand navbar-brand-top" href="admi_home.html">LUZIA</a>

      <!-- Toggler abre el panel derecho -->
      <button class="navbar-toggler ms-auto" type="button"
              data-bs-toggle="offcanvas" data-bs-target="#menuRight"
              aria-controls="menuRight" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menú desktop -->
      <div class="collapse navbar-collapse d-none d-lg-flex">
        <div class="d-flex ms-lg-auto">
          <a class="btn icon-btn" href="admi_productos.html" aria-label="Inventario">
            <i class="bi bi-gear"></i>
          </a>
          <a class="btn icon-btn" href="admi_home.html" aria-label="Vista">
            <i class="bi bi-eye"></i>
          </a>
          <a class="btn icon-btn" href="admi_logout.html" aria-label="Salir">
            <i class="bi bi-door-open"></i>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Offcanvas móvil a la derecha -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="menuRight" aria-labelledby="menuRightLabel">
    <div class="offcanvas-header justify-content-center">
      <h5 class="offcanvas-title" id="menuRightLabel">LUZIA</h5>
      <button type="button" class="btn-close position-absolute end-0 me-3"
              data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
      <!-- Mismos iconos, en columna con texto -->
      <ul class="list-unstyled text-center w-100">
        <li class="mb-3">
          <a href="admi_productos.html" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-gear"></i>
            <span class="small mt-1">Productos</span>
          </a>
        </li>
        <li class="mb-3">
          <a href="admi_home.html" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-eye fs-3"></i>
            <span class="small mt-1">Vista</span>
          </a>
        </li>
        <li>
          <a href="admi_logout.html" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-door-open fs-3"></i>
            <span class="small mt-1">Salir</span>
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
            
            // categoría en mayúscula inicial
            $categoria = ucwords(mb_strtolower($r['categoria']));

            // costo no existe → muestra guion
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

            <h5 class="mb-0" style="color: var(--color-texto2)">Ventas Realizadas</h5>

            <!-- ✅ MENÚ DE FILTRO -->
            <?php
            // Captura segura del filtro
            $filtro = $_GET['estado'] ?? 'Todos';
            ?>
            <form method="GET" class="mt-2" style="max-width:250px;">
                <label class="small">Filtrar por estado:</label>
                <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="Todos" <?= ($filtro=='Todos')?'selected':''; ?>>Todos</option>
                    <option value="Entregado" <?= ($filtro=='Entregado')?'selected':''; ?>>Entregado</option>
                    <option value="En almacen" <?= ($filtro=='En almacen')?'selected':''; ?>>En almacen</option>
                    <option value="Transporte" <?= ($filtro=='Transporte')?'selected':''; ?>>Transporte</option>
                </select>
            </form>
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
// ✅ Datos de ejemplo
$ventasDemo = [
    ["fecha"=>"01/08/2025","cliente"=>"valen12@gmail.com","cantidad"=>2,"estado"=>"Entregado","total"=>88000],
    ["fecha"=>"01/08/2025","cliente"=>"mora22_silva@gmail.com","cantidad"=>4,"estado"=>"En almacen","total"=>164000],
    ["fecha"=>"03/08/2025","cliente"=>"nicooooo_27@hotmail.com","cantidad"=>1,"estado"=>"En almacen","total"=>40000],
    ["fecha"=>"04/08/2025","cliente"=>"fatimarodriguez01@yahoo.com","cantidad"=>2,"estado"=>"Transporte","total"=>70000],
    ["fecha"=>"05/08/2025","cliente"=>"liliansuar3z@gmail.com","cantidad"=>5,"estado"=>"Entregado","total"=>189000],
];

// ✅ Lógica de filtrado corregida
foreach ($ventasDemo as $v) {

    // Si no es "Todos" y no coincide, lo saltamos
    if ($filtro != 'Todos' && $v['estado'] != $filtro) {
        continue;
    }

    $badge = 'bg-secondary';
    if ($v['estado'] == 'Entregado') $badge = 'bg-dark';
    elseif ($v['estado'] == 'En almacen') $badge = 'bg-warning';
    elseif ($v['estado'] == 'Transporte') $badge = 'bg-danger';

    echo "<tr>
        <td>{$v['fecha']}</td>
        <td>{$v['cliente']}</td>
        <td>{$v['cantidad']}</td>
        <td><span class='badge {$badge}'>{$v['estado']}</span></td>
        <td>$".number_format($v['total'],0,',','.')."</td>
    </tr>";
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

