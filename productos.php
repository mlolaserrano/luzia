<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

require __DIR__ . '/conexion.php';

/* Traer TODOS los productos activos */
$stmt = $conn->prepare("
    SELECT id, nombre, categoria, precio
    FROM producto
    WHERE estado = 'activo'
");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Mapeo de imágenes locales */
$imagenes = [
    // ANILLOS
    1 => "img/ANI001anillo_piedra_3.png",
    2 => "img/ANI002anillo_piedra_1.png",
    3 => "img/ANI003anillo_piedra_4.png",

    // AROS
    4 => "img/ARO001aroscolagantes3.jpg",
    5 => "img/aroscolga2.png",
    6 => "img/ARO002aroscolagantes4.png",

    // COLLARES
    7 => "img/COL001gargantilla.png",
    8 => "img/COL002collarlargo.png",

    // BRAZALETES
    9  => "img/BRA001bracelet_fino_2.jpg",
    10 => "img/BRA002bracelet_fino_1.jpg",
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Luzia | Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap" rel="stylesheet">
</head>

<body>

<!-- NAV -->
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid position-relative">

            <a class="navbar-brand navbar-brand-top" href="index.php">LUZIA</a>

            <button class="navbar-toggler ms-auto" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#menuRight">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse d-none d-lg-flex">
                <ul class="navbar-nav mx-lg-3 me-auto">
                    <li class="nav-item"><a class="nav-link" href="productos_aros.php">Aros</a></li>
                    <li class="nav-item"><a class="nav-link" href="productos_anillos.php">Anillos</a></li>
                    <li class="nav-item"><a class="nav-link" href="producto_brazaletes.php">Brazaletes</a></li>
                    <li class="nav-item"><a class="nav-link" href="productos_collares.php">Collares</a></li>
                </ul>

                <div class="d-flex ms-lg-auto">

                    <!-- EMAIL DEL USUARIO -->
                    <a class="btn" href="mi_cuenta.php" aria-label="email">
                        <i class="position-relative"><?php echo $_SESSION['email']; ?></i>
                    </a>

                    <a class="btn icon-btn position-relative" href="carrito.php">
                        <i class="bi bi-cart"></i>
                    </a>
                </div>
            </div>

        </div>
    </nav>

    <!-- MENU MOVIL -->
    <div class="offcanvas offcanvas-end" id="menuRight">
        <div class="offcanvas-header justify-content-center">
            <h5 class="offcanvas-title">LUZIA</h5>
            <button type="button" class="btn-close position-absolute end-0 me-3"
                    data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="productos_aros.php">Aros</a></li>
                <li class="nav-item"><a class="nav-link" href="productos_anillos.php">Anillos</a></li>
                <li class="nav-item"><a class="nav-link" href="producto_brazaletes.php">Brazaletes</a></li>
                <li class="nav-item"><a class="nav-link" href="productos_collares.php">Collares</a></li>
            </ul>

            <hr class="my-3">

            <div class="d-flex justify-content-center gap-3">
                <a href="mi_cuenta.php"><i class="bi bi-person fs-5"></i></a>
                <a href="carrito.php"><i class="bi bi-cart fs-5"></i></a>
            </div>
        </div>
    </div>
</header>


<!-- CONTENIDO -->
<main class="container my-5">
    <h1 class="text-center mb-4">Todos los Productos</h1>

    <!-- Lista de productos -->
    <div class="row g-4">

        <?php foreach ($productos as $p): ?>
            <?php
                $id     = $p['id'];
                $img    = $imagenes[$id] ?? "img/placeholder.jpg";
                $nombre = htmlspecialchars($p['nombre']);
                $precio = number_format($p['precio'], 0, ',', '.');
            ?>
            
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="" class="card-img-top" alt="<?php echo $nombre; ?>">

                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $nombre; ?></h5>
                        <p class="card-text">$<?php echo $precio; ?></p>

                        <a href="detalle_producto.php?id=<?php echo $id; ?>"
                           class="btn btn-dark btn-sm">
                            Ver detalle
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
