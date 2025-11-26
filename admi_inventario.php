<?php
include("connec.php");

// Conectar a la BD
$conn = conectarBDLuzia();

// Traer todos los productos
$productos = $conn->query("SELECT * FROM producto");
?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Gestión de Inventario</title>

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

   <!-- Tu CSS -->
   <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid position-relative">
      <a class="navbar-brand navbar-brand-top" href="admi_home.html">LUZIA</a>
    </div>
  </nav>
</header>

<main>
  <div class="container mt-4">

    <section id="inventario">
      <h2 class="section-title">Gestión de Inventario</h2>

      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="table-dark">
            <tr>
              <th>SKU</th>
              <th>Producto</th>
              <th>Categoría</th>
              <th>Costo</th>
              <th>Precio Venta</th>
              <th>Stock</th>
            </tr>
          </thead>

          <tbody>

          <?php while($p = $productos->fetch_assoc()): ?>
            <tr>
              <td><?php echo $p['sku']; ?></td>
              <td><?php echo $p['nombre']; ?></td>
              <td><?php echo $p['categoria']; ?></td>
              <td>$<?php echo number_format($p['costo'],0,',','.'); ?></td>
              <td>$<?php echo number_format($p['precio'],0,',','.'); ?></td>
              <td><?php echo $p['stock']; ?></td>
            </tr>
          <?php endwhile; ?>

          </tbody>
        </table>
      </div>
    </section>

  </div>
</main>

<footer class="mt-5 text-center">
  <p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
