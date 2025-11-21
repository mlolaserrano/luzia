<?php
include "connec.php";


function main() {

    $conn = conectarBDLuzia();

    if ($conn == NULL) {
        echo "No se pudo conectar a la base de datos.";
        return;
    }

    $sql = "SELECT * FROM producto WHERE estado='activo'";
    $resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - Luzia</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container my-5">
    <h1 class="text-center mb-4 titulo">Nuestros Productos</h1>

    <div class="row g-4">
        <?php while($p = $resultado->fetch_assoc()): ?>

        <div class="col-md-3">
            <div class="card h-100 product-card">

                <?php
                    $imagen = $p['imagen'];
                    if ($imagen == "" || $imagen == NULL) {
                        $imagen = "img/default-product.png";
                    }
                ?>

                <img src="<?= $imagen ?>" class="card-img-top" alt="<?= $p['nombre'] ?>">

                <div class="card-body text-center">
                    <h5 class="card-title"><?= $p['nombre'] ?></h5>
                    <p class="card-text">$<?= number_format($p['precio'],0,',','.') ?></p>

                    <a class="btn btn-outline-primary"
                       href="detalle_producto.php?id=<?= $p['id'] ?>">
                       Ver información
                    </a>
                </div>

            </div>
        </div>

        <?php endwhile; ?>
    </div>
</div>

</body>
</html>

<?php
    cerrarBDConexion($conn);
}

main();
?>
