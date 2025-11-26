<?php

session_start();
include 'connec.php';

// Recoge y sanea datos
$nombre     = htmlspecialchars($_SESSION['nombre']   ?? '', ENT_QUOTES, 'UTF-8');
$apellido   = htmlspecialchars($_SESSION['apellido']   ?? '', ENT_QUOTES, 'UTF-8');
$email      = htmlspecialchars($_SESSION['email']   ?? '', ENT_QUOTES, 'UTF-8');
$dni        = htmlspecialchars($_SESSION['dni']   ?? '', ENT_QUOTES, 'UTF-8');
$telefono   = htmlspecialchars($_SESSION['telefono'] ?? '', ENT_QUOTES, 'UTF-8');

$id_usuario = $_SESSION['id']; // el cliente logueado


// 1. Conecta a la BD
$conn = conectarBDLuzia(); 

// 2. Consulta los pedidos del cliente
$pedidos = NULL;
if ($conn !== NULL) {
    // La función pedidoCliente está en 'connec.php' y devuelve el mysqli_result
    $pedidos = pedidoCliente($conn, $id_usuario);
}

// 3. Cierra la conexión a la BD
cerrarBDConexion($conn); 

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

        <!-- Tipografia -->
        <!-- Asimovian -->

        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap" rel="stylesheet">


<style>
    /* Asegura que el modal y su fondo estén en los niveles Z más altos */
    .modal.show {
        z-index: 1055 !important;
    }
    .modal-backdrop {
        z-index: 1054 !important;
    }
</style>

  </head>

  <body>
   <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid position-relative">
          <!-- Logotipo fijo centrado -->
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
            <a href="carrito.html" class="position-relative">
              <i class="bi bi-cart fs-5"></i>
            </a>
          </div>
        </div>
      </div>
    </header>
<!--  MIS PERFIL -->
    <section class="container py-5">
  <h2 class="mb-4 text-center titulo">Mi cuenta</h2>
  <p class="mb-4 text-center subtitulo">Hola, <?php echo $_SESSION ['email']; ?></p>

  <div class="row g-4">

    <!-- MIS DATOS CON FOTO Y ESTILO -->
<div class="col-12">
  <div class="card shadow-sm">
    <div class="card-body d-flex flex-column flex-md-row align-items-center gap-4">

      <!-- Datos del usuario -->
      <div class="flex-grow-1">
        <h5 class="card-title mb-3">Mis datos</h5>
        <div class="mb-2">
          <i class="bi bi-person-fill me-2 text-secondary"></i>
          <strong>Nombre:</strong> <?php echo $_SESSION ['nombre']; ?>
        </div>
        <div class="mb-2">
          <i class="bi bi-person-fill me-2 text-secondary"></i>
          <strong>Apellido:</strong> <?php echo $_SESSION ['apellido']; ?>
        </div>
        <div class="mb-2">
          <i class="bi bi-envelope-fill me-2 text-secondary"></i>
          <strong>Email:</strong> <?php echo $_SESSION ['email']; ?>
        </div>
        <div class="mb-2">
          <i class="bi bi-credit-card-2-front-fill me-2 text-secondary"></i>
          <strong>DNI:</strong> <?php echo $_SESSION ['dni']; ?>
        </div>
        <div class="mb-2">
          <i class="bi bi-telephone-fill me-2 text-secondary"></i>
          <strong>Teléfono:</strong> <?php echo $_SESSION ['telefono']; ?>
        </div>
        <button class="btn btn-luzia mt-3" data-bs-toggle="modal" data-bs-target="#modalEditarDatos">
          <i class="bi bi-pencil-square"></i> Editar
        </button>
      </div>

    </div>
  </div>
</div>

    <!--  MIS COMPRAS -->
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Mis compras</h5>
          <hr>
            <?php if ($pedidos && $pedidos->num_rows > 0): ?> 
            <?php while ($pedido = $pedidos->fetch_assoc()): ?>
            <p>
              <button class="btn btn-outline-dark p-2 text-decoration-none" 
                      data-bs-toggle="modal" 
                      data-bs-target="#modalOrden<?= $pedido['id'] ?>">
              <strong>Orden #<?= $pedido['id'] ?></strong>
              </button> — <?= $pedido['fecha'] ?>
            </p>
            <hr>
          <?php endwhile; ?>
          <?php else: ?>
            <p class="text-muted">Aún no tienes compras realizadas.</p>
          <?php endif; ?>
        </div>
      </div>
</div>

    <!-- ACCIONES DE CUENTA -->
    <div class="col-12 text-center pt-4">
      <button class="btn btn-outline-dark me-2" data-bs-toggle="modal" data-bs-target="#modalCerrarSesion">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
      </button>
    </div>

  </div>
</section>

<!--mod de editar info personal-->
<div class="modal fade" id="modalEditarDatos" tabindex="-1" aria-labelledby="modalEditarDatosLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarDatosLabel">Editar mis datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="editar_cliente.php">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo $_SESSION ['nombre'];?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Apellido</label>
            <input type="text" class="form-control" name="apellido" value="<?php echo $_SESSION ['apellido'];?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <p> <?php echo $_SESSION ['email'];?></p>
          </div>
          <div class="mb-3">
            <label class="form-label">DNI</label>
            <p> <?php echo $_SESSION ['dni'];?></p>
          </div>
          <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="tel" class="form-control" name="telefono" value="<?php echo $_SESSION ['telefono'];?>">
          </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-luzia" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-luzia">Guardar cambios</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>
</div>


<?php
// Generar modales dinámicos
if ($pedidos && $pedidos->num_rows > 0) {
    $pedidos->data_seek(0); // Vuelve al inicio del result set para el segundo bucle

    while ($pedido = $pedidos->fetch_assoc()):
        // *** 1. OBTENER DETALLE DE PRODUCTOS PARA CADA PEDIDO ***
        // Reabrir y cerrar la conexión para la consulta de detalle
        $conn = conectarBDLuzia(); 
        $detalle_productos = detallePedidoCliente($conn, $pedido['id']);
        cerrarBDConexion($conn); 
?>
<div class="modal fade" id="modalOrden<?= $pedido['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detalle de la Orden #<?= $pedido['id'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p><strong>Fecha:</strong> <?= $pedido['fecha'] ?></p>
        <p><strong>Estado:</strong> <?= $pedido['estado'] ?></p>
        <hr>
        <h6>Producto:</h6>
        <ul class="list-unstyled">
            <?php 

              if ($detalle_productos && $detalle_productos->num_rows > 0):
                while ($item = $detalle_productos->fetch_assoc()): 
                    // Calcula el subtotal para ese ítem específico
                  $subtotal = $item['Precio unitario'] * $item['Cantidad'];
            ?>
        <li class="d-flex align-items-center mb-3">
          <img src="img/<?= $item['Foto'] ?>" alt="<?= $item['Producto'] ?>" class="me-3 rounded" style="width: 60px; height: auto;">
          <div>
            <p class="mb-0"><strong><?= $item['Producto'] ?></strong> (x<?= $item['Cantidad'] ?>)</p>
            <small>$<?= number_format($subtotal, 2) ?> ($<?= number_format($item['Precio unitario'], 2) ?> c/u)</small>
          </div>
        </li>
            <?php 
                  endwhile; 
                $detalle_productos->free(); // Libera el resultado
              endif; 
            ?>
        </ul>
        <hr>
        <p><strong>Total de la Orden:</strong> $<?= number_format($pedido['total'], 2) ?></p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-luzia" data-bs-dismiss="modal">Cerrar</button>
              </div>

    </div>
  </div>
</div>
<?php 
    endwhile; 
}
?>


<!--mod de cerrar sesión-->
<div class="modal fade" id="modalCerrarSesion" tabindex="-1" aria-labelledby="modalCerrarSesionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCerrarSesionLabel">¿Cerrar sesión?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que querés cerrar sesión?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a href="logout.php" class="btn btn-dark">Cerrar sesión</a>
      </div>
    </div>
  </div>
</div>


    <footer class="mt-5">
  <p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
  <div class="d-flex flex-wrap justify-content-center gap-3">
    <a href="politicas.html">Política de privacidad</a>
    <a href="terminos.html">Términos y condiciones</a>
    <a href="contacto.html">Contacto</a>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
