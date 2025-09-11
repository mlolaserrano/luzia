<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. Recoger y sanear datos
$nombre   = htmlspecialchars($_POST['nombre']   ?? '', ENT_QUOTES, 'UTF-8');
$email    = htmlspecialchars($_POST['email']    ?? '', ENT_QUOTES, 'UTF-8');
$consulta = htmlspecialchars($_POST['consulta'] ?? '', ENT_QUOTES, 'UTF-8');

// 2. Preparar email
$to      = 'mariana.lizza30@gmail.com';
$subject = "Nueva consulta desde Luzia: $nombre";
$message = 
  "Has recibido una nueva consulta desde tu web Luzia:\n\n" .
  "Nombre: $nombre\n" .
  "Email: $email\n\n" .
  "Consulta:\n$consulta\n";
$headers  = "From: noreply@tuluzia.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// 3. Enviar correo
/*mail($to, $subject, $message, $headers);*/
?>
<!doctype html>
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

        <!-- Tipografia -->
        <!-- Asimovian -->

        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap" rel="stylesheet">

  </head>
<body class="bg-light d-flex flex-column min-vh-100">

 <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid position-relative">
          <!-- Brand fijo centrado -->
          <a class="navbar-brand navbar-brand-top" href="index.html">LUZIA</a>

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
                <a class="nav-link active" href="productos_aros.html">Aros</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="productos_anillos.html">Anillos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="producto_brazaletes.html"
                  >Brazaletes</a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="productos_collares.html">Collares</a>
              </li>
            </ul>
            <div class="d-flex ms-lg-auto">
              <a class="btn icon-btn" href="login.html" aria-label="Usuario"
                ><i class="bi bi-person"></i
              ></a>
              <a
                class="btn icon-btn position-relative"
                href="carrito.html"
                aria-label="Carrito"
              >
                <i class="bi bi-cart"></i><span class="cart-counter">0</span>
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
              <a class="nav-link py-2" href="productos_aros.html">Aros</a>
            </li>
            <li class="nav-item">
              <a class="nav-link py-2" href="productos_anillos.html">Anillos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link py-2" href="producto_brazaletes.html"
                >Brazaletes</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link py-2" href="productos_collares.html"
                >Collares</a
              >
            </li>
          </ul>

          <hr class="my-3" />

          <div class="d-flex justify-content-center gap-3">
            <a href="login.html"><i class="bi bi-person fs-5"></i></a>
            <a href="carrito.html" class="position-relative">
              <i class="bi bi-cart fs-5"></i>
              <span class="cart-counter">0</span>
            </a>
          </div>
        </div>
      </div>
    </header>

  <main class="flex-fill d-flex align-items-center justify-content-center">
    <div class="card shadow-sm w-100 mw-600 px-3 py-5">
      <div class="card-body text-center">
        <h1 class="card-title mb-4">¡Gracias, <?php echo $nombre; ?>!</h1>
        <p class="mb-3">Hemos recibido tu consulta:</p>
        <blockquote class="blockquote mb-4 text-start">
          <?php echo nl2br($consulta); ?>
        </blockquote>
        <p class="mb-4">
          Te responderemos en breve al correo
          <strong><?php echo $email; ?></strong>.
        </p>
        <a href="index.html" class="btn btn-luzia">Volver al inicio</a>
      </div>
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


  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous">
  </script>
</body>
</html>