<?php 
include("connec.php");

// Llamamos a la función que CREA la conexión
$conexion = conectarBDLuzia();

// Pedimos los productos activos
$consulta = $conexion->query("SELECT * FROM producto WHERE estado='activo'");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"> 
  <title>Listado de Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
  <h1 class="text-center mb-4">Nuestros Productos</h1>

  <div class="row g-4">

    <?php while($p = $consulta->fetch_assoc()): ?>
      <div class="col-md-3">
        <div class="card h-100">

          <?php 
            $imagen = $p['imagen']; 
            if ($imagen == "") { 
              $imagen = "img/default-product.png";
            }
          ?>
          <img src="<?php echo $imagen; ?>" class="card-img-top" alt="<?php echo $p['nombre']; ?>">

          <div class="card-body text-center">
            <h5 class="card-title"><?php echo $p['nombre']; ?></h5>
            <p class="card-text">$<?php echo number_format($p['precio'], 0, ',', '.'); ?></p>
            <a class="btn btn-outline-primary" href="#">Ver información</a>
          </div>

        </div>
      </div>
    <?php endwhile; ?>

  </div>
</div>

</body>
</html>