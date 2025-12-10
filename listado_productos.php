<?php
session_start();

// productos
$productos = [
    ["nombre"=>"Aros Celia","precio"=>39000,"imagen"=>"master/aroscolagantes4.jpg","detalle"=>"detalle_producto.html"],
    ["nombre"=>"Aros Aura","precio"=>47000,"imagen"=>"img/ARO001aroscolagantes3.jpg","detalle"=>"detalle_producto.html"],
    ["nombre"=>"Aros Amaré","precio"=>41000,"imagen"=>"img/aroscolga2.png","detalle"=>"detalle_producto.html"],
    ["nombre"=>"Anillo Cromática","precio"=>30000,"imagen"=>"img/ANI002anillo_piedra_1.png","detalle"=>"detalle_producto.html"],
    ["nombre"=>"Anillo Cloe","precio"=>40000,"imagen"=>"img/ANI003anillo_piedra_4.png","detalle"=>"detalle_producto.html"],
    ["nombre"=>"Anillo Aurora","precio"=>53000,"imagen"=>"img/ANI001anillo_piedra_3.png","detalle"=>"detalle_producto.html"],
    ["nombre"=>"Brazalete Iris","precio"=>29000,"imagen"=>"master/bracelet_2.png","detalle"=>"detalle_producto.html"],
    ["nombre"=>"Brazalete Amelia","precio"=>37000,"imagen"=>"master/bracelet_6.png","detalle"=>"detalle_producto.html"],
    ["nombre"=>"Collar Selene","precio"=>47000,"imagen"=>"img/COL001gargantilla.png","detalle"=>"detalle_producto.html"],
    ["nombre"=>"Collar Lyra","precio"=>44000,"imagen"=>"img/COL002collarlargo.png","detalle"=>"detalle_producto.html"],
];
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
<style>
body { display:flex; flex-direction: column; min-height: 100vh; }
main { flex:1; }
.card-img-top { object-fit: cover; height: 200px; }
footer { background-color: #000; color:#fff; padding:1rem 0; text-align:center; }
footer a { color:#fff; margin:0 0.5rem; text-decoration:none; }
</style>
</head>
<body>

<!-- NAVBAR CON OFFCANVAS -->
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
          <li class="nav-item"><a class="nav-link active" href="productos_aros.html">Aros</a></li>
          <li class="nav-item"><a class="nav-link" href="productos_anillos.html">Anillos</a></li>
          <li class="nav-item"><a class="nav-link" href="producto_brazaletes.html">Brazaletes</a></li>
          <li class="nav-item"><a class="nav-link" href="productos_collares.html">Collares</a></li>
        </ul>
        <div class="d-flex ms-lg-auto">
          <!-- Usuario y carrito -->
          <span class="me-2"><?= htmlspecialchars($_SESSION['email'] ?? 'Invitado') ?></span>
          <a class="btn icon-btn" href="login.php"><i class="bi bi-person"></i></a>
          <a class="btn icon-btn position-relative" href="carrito.php">
            <i class="bi bi-cart"></i><span class="cart-counter">0</span>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Offcanvas móvil a la derecha -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="menuRight" aria-labelledby="menuRightLabel">
    <div class="offcanvas-header justify-content-center">
      <h5 class="offcanvas-title" id="menuRightLabel">LUZIA</h5>
      <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link py-2" href="productos_aros.php">Aros</a></li>
        <li class="nav-item"><a class="nav-link py-2" href="productos_anillos.php">Anillos</a></li>
        <li class="nav-item"><a class="nav-link py-2" href="producto_brazaletes.php">Brazaletes</a></li>
        <li class="nav-item"><a class="nav-link py-2" href="productos_collares.php">Collares</a></li>
      </ul>
      <hr class="my-3">
      <div class="d-flex justify-content-center gap-3">
        <span><?= htmlspecialchars($_SESSION['email'] ?? 'Invitado') ?></span>
        <a href="login.php"><i class="bi bi-person fs-5"></i></a>
        <a href="carrito.php" class="position-relative">
          <i class="bi bi-cart fs-5"></i><span class="cart-counter">0</span>
        </a>
      </div>
    </div>
  </div>
</header>

<!-- MAIN -->
<main class="container my-5">
  <div class="text-center mb-5">
    <h1 class="fw-bold">Nuestros Productos</h1>
    <p class="lead">Disfrutá de nuestra colección de joyas exclusivas</p>
  </div>
  <div class="row g-4">
    <?php foreach($productos as $p): ?>
      <div class="col-md-3">
        <div class="card h-100">
          <img src="<?= $p['imagen'] ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nombre']) ?>">
          <div class="card-body text-center">
            <h5 class="card-title"><?= htmlspecialchars($p['nombre']) ?></h5>
            <p class="card-text">$<?= number_format($p['precio'],0,",",".") ?></p>
            <a class="btn btn-outline-primary w-100" href="<?= $p['detalle'] ?>">Ver información</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<!-- FOOTER -->
<footer>
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
