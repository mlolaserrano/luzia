<?php
// --- gracias.php ---

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
mail($to, $subject, $message, $headers);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gracias por tu consulta | Luzia</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

  <header class="py-3 bg-white shadow-sm">
    <div class="container text-center">
      <a href="index.html" class="navbar-brand fs-3">LUZIA</a>
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

  <footer class="py-3 text-center">
    <small>&copy; 2024 Luzia. Todos los derechos reservados.</small>
  </footer>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous">
  </script>
</body>
</html>