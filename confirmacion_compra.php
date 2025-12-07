<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html"); // Redirigir si no ha iniciado sesión
    exit();
}

require __DIR__ . '/conexion.php';

// Obtener el email del usuario logueado
$email = $_SESSION['email'];

// Buscar nombre en la tabla usuario
$stmt = $conn->prepare("
    SELECT nombre
    FROM usuario
    WHERE email = ?
    LIMIT 1
");
$stmt->execute([$email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no encuentra usuario
$nombre = $usuario ? $usuario['nombre'] : "Cliente";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Luzia más que joyas</title>

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

  <body class="bg-light">
    <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid position-relative">
          <!-- Brand fijo centrado -->
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
            <div class="d-flex ms-lg-auto">
              <!-- Email del usuario -->
              <a class="btn" href="mi_cuenta.php" aria-label="email">
                <i class="position-relative"><?php echo htmlspecialchars($_SESSION['email']); ?></i>
              </a>
              <a class="btn icon-btn position-relative" href="carrito.php" aria-label="Carrito">
                <i class="bi bi-cart"></i>
              </a>
            </div>
          </div>
        </div>
      </nav>

      <!-- Offcanvas móvil a la derecha -->
      <div
        class="offcanvas offcanvas-end"
        tabindex="-1"
        id="menuRight"
        aria-labelledby="menuRightLabel"
      >
        <div class="offcanvas-header justify-content-center">
          <h5 class="offcanvas-title" id="menuRightLabel">LUZIA</h5>
          <button
            type="button"
            class="btn-close position-absolute end-0 me-3"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
          ></button>
        </div>

        <div class="offcanvas-body">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link py-2" href="productos_aros.php">Aros</a>
            </li>
            <li class="nav-item">
              <a class="nav-link py-2" href="productos_anillos.php">Anillos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link py-2" href="producto_brazaletes.php">Brazaletes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link py-2" href="productos_collares.php">Collares</a>
            </li>
          </ul>

          <hr class="my-3" />

          <div class="d-flex justify-content-center gap-3">
            <a href="mi_cuenta.php"><i class="bi bi-person fs-5"></i></a>
            <a href="carrito.php" class="position-relative">
              <i class="bi bi-cart fs-5"></i>
            </a>
          </div>
        </div>
      </div>
    </header>

    <main class="container text-center mt-5">
      <div class="card shadow p-5 mx-auto" style="max-width: 600px;">
        <h1 class="mb-3">
          ¡Gracias por tu compra, <strong><?php echo htmlspecialchars($nombre); ?></strong>!
        </h1>

        <p class="lead">
          En breve nos estaremos contactando para coordinar el método de entrega.
        </p>

        <a href="index.php" class="btn btn-primary mt-3">Volver al inicio</a>
      </div>
    </main>

    <footer class="mt-5">
      <p class="text-center">&copy; 2024 Luzia. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  </body>
</html>
