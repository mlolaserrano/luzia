<?php
include "connec.php";

$conn = conectarBDLuzia();

if (!$conn) {
    die("Error de conexión a la base de datos");
}

$sql = "SELECT * FROM producto WHERE estado = 'activo'";
$resultado = $conn->query($sql);
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Luzia | Productos</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.html">LUZIA</a>
    </div>
  </nav>
</header>

<main class="container my-5">

  <div class="text-center mb-5">
    <h1 class="fw-bold">Nuestros Productos</h1>
    <p class="lead">Disfrutá de nuestra colección de joyas exclusivas</p>
  </div>

  <div class="row g-4">

    <?php while($p = $resultado->fetch_assoc()): ?>

      <?php
        $imagen = $p['imagen'];

        if ($imagen == "" || $imagen == NULL) {
          $rutaImagen = "img/default-product.png";
        } else {
          // Probar primero en /img/
          if (file_exists("img/" . $imagen)) {
            $rutaImagen = "img/" . $imagen;
          } elseif (file_exists("master/" . $imagen)) {
            $rutaImagen = "master/" . $imagen;
          } else {
            $rutaImagen = "img/default-product.png";
          }
        }
      ?>

      <div class="col-md-3">
        <div class="card h-100">
          <img src="<?= $rutaImagen ?>" class="card-img-top" alt="<?= $p['nombre'] ?>">

          <div class="card-body text-center">
            <h5 class="card-title"><?= $p['nombre'] ?></h5>
            <p class="card-text">$<?= number_format($p['precio'], 0, ',', '.') ?></p>

            <a class="btn btn-outline-primary" href="detalle_producto.php?id=<?= $p['id'] ?>">
              Ver información
            </a>
          </div>
        </div>
      </div>

    <?php endwhile; ?>

  </div>

</main>

<footer class="mt-5 text-center p-3 bg-light">
  <p>&copy; 2024 Luzia. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>