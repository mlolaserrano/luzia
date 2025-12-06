<?php  
include("connec.php");

// 1) Chequeamos si viene el ID del producto
if (!isset($_GET['id'])) {
    die("No se indicó un producto válido.");
}

$id = $_GET['id'];

// 2) Conectamos a la BD
$conexion = conectarBDLuzia();

// 3) Buscamos el producto por ID
$consulta = $conexion->query("SELECT * FROM producto WHERE id = $id");
$producto = $consulta->fetch_assoc();

if (!$producto) {
    die("Producto no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $producto['nombre']; ?> | Luzia</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap" rel="stylesheet" />
</head>

<body>

  <!-- NAV -->
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid position-relative">
        <a class="navbar-brand navbar-brand-top" href="index.html">LUZIA</a>

        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuRight">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-none d-lg-flex">
          <ul class="navbar-nav mx-lg-3 me-auto">
            <li class="nav-item">
              <a class="nav-link active" href="productos_aros.html">Aros</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="productos_anillos.html">Anillos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="producto_brazaletes.html">Brazaletes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="productos_collares.html">Collares</a>
            </li>
          </ul>

          <div class="d-flex ms-lg-auto">
            <a class="btn icon-btn" href="login.html"><i class="bi bi-person"></i></a>
            <a class="btn icon-btn position-relative" href="carrito.html">
              <i class="bi bi-cart"></i><span class="cart-counter">0</span>
            </a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <!-- CONTENIDO -->
  <main class="container my-5">
    <div class="row">

      <!-- IMAGEN -->
      <div class="col-12 col-md-6 text-center mb-3">
        <img src="<?php echo $producto['imagen']; ?>" 
             class="img-fluid rounded shadow-sm"
             alt="Imagen de <?php echo $producto['nombre']; ?>">
      </div>

      <!-- DETALLE DEL PRODUCTO -->
      <div class="col-12 col-md-6 mt-4 mt-md-0">
        <div class="product-info p-4 border rounded shadow-sm">

          <h1 class="display-5 fw-bold mb-2" style="color: var(--color-primario)">
            <?php echo $producto['nombre']; ?>
          </h1>

          <p class="lead text-muted mb-3">
            SKU: <?php echo $producto['sku']; ?>
          </p>

          <h2 class="fw-bold my-4" style="color: var(--color-primario)">
            $<?php echo number_format($producto['precio'], 0, ',', '.'); ?>
          </h2>

          <div class="mb-4">
            <p><strong>Descripción:</strong></p>
            <p><?php echo $producto['descripcion']; ?></p>
          </div>

          <!-- BOTÓN CARRITO -->
          <div class="d-grid gap-2">
            <button class="btn btn-lg btn-carrito" type="button">
              Añadir al Carrito
            </button>
          </div>

        </div>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="mt-5">
    <p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
    <div class="d-flex flex-wrap justify-content-center gap-3">
      <a href="politicas.html">Política de privacidad</a>
      <a href="terminos.html">Términos y condiciones</a>
      <a href="contacto.html">Contacto</a>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>

</body>
</html>
