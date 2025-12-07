<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

require __DIR__ . '/conexion.php';

/* Traer AROS desde la BD */
$stmt = $conn->prepare("
    SELECT id, nombre, precio
    FROM producto
    WHERE categoria = 'aros' AND estado = 'activo'
");
$stmt->execute();
$aros = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Mapeo de imágenes de aros (ya que no están en BD) */
$imagenes_aros = [
    4 => "img/ARO001aroscolagantes3.jpg",  // Aros Aura
    5 => "master/aroscolagantes4.jpg",    // Aros Celia
    6 => "img/aroscolga2.png",            // Aros Amaré
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Luzia | Aros</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid position-relative">

        <a class="navbar-brand navbar-brand-top" href="index.php">LUZIA</a>

        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuRight">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- NAV DESKTOP -->
        <div class="collapse navbar-collapse d-none d-lg-flex">
          <ul class="navbar-nav mx-lg-3 me-auto">
            <li class="nav-item"><a class="nav-link active" href="productos_aros.php">Aros</a></li>
            <li class="nav-item"><a class="nav-link" href="productos_anillos.php">Anillos</a></li>
            <li class="nav-item"><a class="nav-link" href="producto_brazaletes.php">Brazaletes</a></li>
            <li class="nav-item"><a class="nav-link" href="productos_collares.php">Collares</a></li>
          </ul>

          <div class="d-flex ms-lg-auto">
            <a class="btn" href="mi_cuenta.php"><i><?php echo $_SESSION['email']; ?></i></a>
            <a class="btn icon-btn position-relative" href="carrito.php">
              <i class="bi bi-cart"></i>
            </a>
          </div>

        </div>
      </div>
    </nav>
  </header>

  <main class="container my-5">
    <div class="text-center mb-5">
      <h1 class="fw-bold">Aros</h1>
      <p class="lead">Disfrutá de nuestra colección de aros exclusivos</p>
    </div>

    <div class="row g-4">
      <?php foreach ($aros as $aro): ?>
        <?php
          $id = $aro['id'];
          $img = $imagenes_aros[$id] ?? "img/placeholder.jpg";
        ?>
        <div class="col-md-3">
          <div class="card h-100">
            <img src="<?php echo $img; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($aro['nombre']); ?>" />

            <div class="card-body text-center">
              <h5 class="card-title"><?php echo htmlspecialchars($aro['nombre']); ?></h5>

              <p class="card-text">
                $<?php echo number_format($aro['precio'], 0, ',', '.'); ?>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
