<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

require __DIR__ . '/conexion.php';

/* Traer anillos desde la BD */
$stmt = $conn->prepare("
    SELECT id, nombre, precio,imagen
    FROM producto
    WHERE categoria = 'anillos' AND estado = 'activo'
");
$stmt->execute();
$anillos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// CALCULAR TOTALES 
$cart_items    = $_SESSION['carrito'];
$cart_count    = 0;
$cart_subtotal = 0;

foreach ($cart_items as $item) {
    $cart_count    += $item['cantidad'];
    $cart_subtotal += $item['precio'] * $item['cantidad'];
}

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Luzia | Anillos</title>

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

    <!-- Tipografía Asimovian -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap" rel="stylesheet">
  </head>

  <body>
    <header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid position-relative">
      <!-- Logotipo fijo centrado -->
      <a class="navbar-brand navbar-brand-top" href="index.php">LUZIA</a>

      <!-- Toggler abre el panel derecho -->
      <button
        class="navbar-toggler ms-auto"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#menuRight"
        aria-controls="menuRight"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menú desktop normal -->
      <div class="collapse navbar-collapse d-none d-lg-flex">
        <ul class="navbar-nav mx-lg-3 me-auto">
          <li class="nav-item">
            <a class="nav-link active" href="productos_aros.php">Aros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="productos_anillos.php">Anillos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="producto_brazaletes.php">Brazaletes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="productos_collares.php">Collares</a>
          </li>
        </ul>

        <!-- PERSONALIZACIÓN -->
        <div class="d-flex ms-lg-auto align-items-center">
          <!-- Aquí se muestra el nombre y apellido del usuario -->
          <a class="btn" href="mi_cuenta.php" aria-label="email">
            <i class="position-relative">
              <?php echo $_SESSION ['nombre']." ". $_SESSION ['apellido']; ?>
            </i>
          </a>

          <a
            class="btn icon-btn position-relative ms-2"
            href="carrito.php"
            aria-label="Carrito"
          >
            <i class="bi bi-cart"></i>
            <span class="cart-counter"><?php echo $cart_count; ?></span>
          </a>
        </div>
      </div>
    </div>
  </nav>
</header>


    <main class="container my-5">
      <div class="text-center mb-5">
        <h1 class="fw-bold">Anillos</h1>
        <p class="lead">Disfrutá de nuestra colección de anillos exclusivos</p>
      </div>

      <div class="row g-4">
        <?php foreach ($anillos as $ani): ?>
          <?php
            $id  = $ani['id'];
            $img = $ani['imagen'] ?? 'https://raw.githubusercontent.com/mlolaserrano/luzia/desarrollo/img/ANI001anillo_piedra_3.png';
          ?>
          <div class="col-md-3">
            <div class="card h-100">
              <img src="<?php echo htmlspecialchars($img); ?>"
                   class="card-img-top"
                   alt="<?php echo htmlspecialchars($ani['nombre']); ?>">
              <div class="card-body text-center">
                <h5 class="card-title">
                  <?php echo htmlspecialchars($ani['nombre']); ?>
                </h5>
                <p class="card-text">
                  $<?php echo number_format($ani['precio'], 0, ',', '.'); ?>
                </p>
                <a class="btn btn-outline-primary"
                   href="detalle_producto.php?id=<?php echo $id; ?>">
                  Ver información
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </main>

    <footer class="mt-5">
      <p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
      <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="politicas.html">Política de privacidad</a>
        <a href="terminos.html">Términos y condiciones</a>
        <a href="contacto.html">Contacto</a>
      </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
  </body>
</html>
