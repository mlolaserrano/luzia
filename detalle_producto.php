<?php
session_start();


if (!isset($producto)) {
    $producto = [
        'id'          => 'ANI001',
        'nombre'      => 'Anillo Aurora',
        'sku'         => 'ANI001',
        'precio'      => 53000,
        'imagen'      => 'img/ANI001anillo_piedra_3.png',
        'descripcion' => 'Anillo en oro 18K, hecho a mano.'
    ];
}

/* Inicializar carrito */
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

/* Flags */
$producto_agregado = false;

/* MANEJO DE ACCIONES DEL CARRITO */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ELIMINAR UN PRODUCTO
    if (isset($_POST['remove_item'])) {
        $id = $_POST['id'] ?? null;
        if ($id !== null && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
    }

    // VACIAR TODO
    elseif (isset($_POST['empty_cart'])) {
        $_SESSION['carrito'] = [];
    }

    // AUMENTAR CANTIDAD
    elseif (isset($_POST['increase_qty'])) {
        $id = $_POST['id'] ?? null;
        if ($id !== null && isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        }
    }

    // DISMINUIR CANTIDAD
    elseif (isset($_POST['decrease_qty'])) {
        $id = $_POST['id'] ?? null;
        if ($id !== null && isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']--;
            if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$id]);
            }
        }
    }

    // AÑADIR AL CARRITO
    elseif (isset($_POST['add_to_cart'])) {
        $id     = $_POST['id'];
        $nombre = $_POST['nombre'];
        $precio = (float) $_POST['precio'];
        $imagen = $_POST['imagen'];

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad'] += 1;
        } else {
            $_SESSION['carrito'][$id] = [
                'id'       => $id,
                'nombre'   => $nombre,
                'precio'   => $precio,
                'imagen'   => $imagen,
                'cantidad' => 1,
            ];
        }

        $producto_agregado = true;
    }
}

/* Datos del carrito para el icono y el offcanvas */
$cart_items    = $_SESSION['carrito'];
$cart_count    = 0;
$cart_subtotal = 0;

foreach ($cart_items as $item) {
    $cart_count    += $item['cantidad'];
    $cart_subtotal += $item['precio'] * $item['cantidad'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($producto['nombre']); ?> | Luzia</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <!-- NAVBAR -->
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
            <li class="nav-item">
              <a class="nav-link" href="productos_aros.php">Aros</a>
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
            <a class="btn icon-btn" href="login.php" aria-label="Usuario">
              <i class="bi bi-person"></i>
            </a>

            <!-- Icono de carrito que abre el mini-carrito -->
            <button class="btn icon-btn position-relative"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#miniCarrito"
                    aria-label="Carrito">
              <i class="bi bi-cart"></i>
              <span class="cart-counter"><?php echo $cart_count; ?></span>
            </button>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <!-- CONTENIDO DETALLE PRODUCTO -->
  <main class="container my-5">
    <div class="row">
      <!-- Imagen -->
      <div class="col-12 col-md-6 text-center mb-3">
        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>"
             class="img-fluid rounded shadow-sm"
             alt="Imagen de <?php echo htmlspecialchars($producto['nombre']); ?>">
      </div>

      <!-- Info -->
      <div class="col-12 col-md-6 mt-4 mt-md-0">
        <div class="product-info p-4 border rounded shadow-sm">

          <h1 class="display-5 fw-bold mb-2" style="color: var(--color-primario)">
            <?php echo htmlspecialchars($producto['nombre']); ?>
          </h1>

          <p class="lead text-muted mb-3">
            SKU: <?php echo htmlspecialchars($producto['sku']); ?>
          </p>

          <h2 class="fw-bold my-4" style="color: var(--color-primario)">
            $<?php echo number_format($producto['precio'], 0, ',', '.'); ?>
          </h2>

          <div class="mb-4">
            <p><strong>Descripción:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></p>
          </div>

          <!-- BOTÓN AÑADIR AL CARRITO -->
          <div class="d-grid gap-2">
            <form method="POST">
              <input type="hidden" name="id"     value="<?php echo htmlspecialchars($producto['id']); ?>">
              <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
              <input type="hidden" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>">
              <input type="hidden" name="imagen" value="<?php echo htmlspecialchars($producto['imagen']); ?>">

              <button class="btn btn-lg btn-carrito" type="submit" name="add_to_cart">
                Añadir al Carrito
              </button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </main>

  <!-- MINI-CARRITO (OFFCANVAS) -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="miniCarrito" aria-labelledby="miniCarritoLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="miniCarritoLabel">Carrito</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

      <?php if ($cart_count === 0): ?>

        <p class="fw-bold mb-1">Tu carrito está vacío.</p>
        <p class="text-muted small">Agregá productos para continuar.</p>

      <?php else: ?>

        <?php if ($producto_agregado): ?>
          <div class="alert alert-success py-2 small mb-3">
            <i class="bi bi-check-circle-fill me-1"></i>
            Producto añadido a tu carrito
          </div>
        <?php endif; ?>

        <?php foreach ($cart_items as $item): ?>
          <div class="d-flex mb-3 align-items-start">

            <!-- IMAGEN -->
            <?php if (!empty($item['imagen'])): ?>
              <img src="<?php echo htmlspecialchars($item['imagen']); ?>"
                   class="rounded me-3"
                   style="width:60px;height:60px;object-fit:cover;">
            <?php endif; ?>

            <div class="flex-grow-1">
              <p class="m-0 fw-semibold">
                <?php echo htmlspecialchars($item['nombre']); ?>
              </p>

              <!-- CONTADOR + / - -->
              <form method="POST" class="mt-1 d-inline-flex align-items-center">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">

                <button type="submit" name="decrease_qty"
                        class="btn btn-sm px-2 py-1 border">
                  -
                </button>

                <input type="text"
                       readonly
                       value="<?php echo (int) $item['cantidad']; ?>"
                       class="form-control form-control-sm text-center mx-1"
                       style="width:45px;">

                <button type="submit" name="increase_qty"
                        class="btn btn-sm px-2 py-1 border">
                  +
                </button>
              </form>

              <p class="m-0 mt-1">
                $<?php echo number_format($item['precio'], 0, ',', '.'); ?>
              </p>
            </div>

            <!-- BOTÓN ELIMINAR ESTE PRODUCTO -->
            <form method="POST" class="ms-2">
              <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
              <button type="submit" name="remove_item"
                      class="btn btn-sm text-danger"
                      aria-label="Eliminar del carrito">
                <i class="bi bi-trash"></i>
              </button>
            </form>

          </div>
        <?php endforeach; ?>

        <div class="d-flex justify-content-between mt-3 mb-2">
          <span class="fw-semibold">Subtotal</span>
          <span class="fw-bold">
            $<?php echo number_format($cart_subtotal, 0, ',', '.'); ?>
          </span>
        </div>

        <p class="text-muted small mb-3">
          Los descuentos se aplicarán en el carrito.
        </p>

        <a href="carrito.php" class="btn btn-primary w-100 mb-2">
          Finalizar compra
        </a>

        <!--  BOTÓN VACIAR TODO EL CARRITO -->
        <form method="POST" class="text-end">
          <button type="submit" name="empty_cart"
                  class="btn btn-link btn-sm text-danger">
            Vaciar carrito
          </button>
        </form>

      <?php endif; ?>

    </div>
  </div>

  <!-- FOOTER -->
  <footer class="mt-5">
    <p class="text-center">&copy; 2024 Luzia. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
          crossorigin="anonymous"></script>

  <?php if ($producto_agregado): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var offcanvasEl = document.getElementById('miniCarrito');
      var offcanvas = new bootstrap.Offcanvas(offcanvasEl);
      offcanvas.show();
    });
  </script>
  <?php endif; ?>

</body>
</html>
