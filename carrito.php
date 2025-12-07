


<?php
session_start();
require __DIR__ . '/conexion.php'; // si no lo usás adentro, igual no rompe

/* 1) INICIALIZAR CARRITO */
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

/* 2) MANEJO DE ACCIONES ( + , - , eliminar, vaciar ) */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Eliminar un ítem
    if (isset($_POST['remove_item'])) {
        $id = $_POST['id'] ?? null;
        if ($id !== null && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
    }

    // Vaciar carrito
    elseif (isset($_POST['empty_cart'])) {
        $_SESSION['carrito'] = [];
    }

    // Aumentar cantidad
    elseif (isset($_POST['increase_qty'])) {
        $id = $_POST['id'] ?? null;
        if ($id !== null && isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        }
    }

    // Disminuir cantidad
    elseif (isset($_POST['decrease_qty'])) {
        $id = $_POST['id'] ?? null;
        if ($id !== null && isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']--;
            if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$id]);
            }
        }
    }

    // Después de cualquier acción, recargar para evitar re-envío del POST
    header("Location: carrito.php");
    exit;
}

/* 3) CALCULAR TOTALES */
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
    <title>Luzia | Carrito</title>

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

    <!-- Tipografía -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap"
      rel="stylesheet"
    />
  </head>

  <body>
    <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid position-relative">
          <!-- Logotipo fijo centrado -->
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
                <a class="nav-link" href="producto_brazaletes.php"
                  >Brazaletes</a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="productos_collares.php">Collares</a>
              </li>
            </ul>
            <div class="d-flex ms-lg-auto">
                  <div class="d-flex ms-lg-auto">
              
              <!-- Aquí se muestra el email del usuario -->
             
              <a class="btn" href="mi_cuenta.php" aria-label="email">
                <i class="position-relative"><?php echo $_SESSION['email'];?></i>
              </a>
              <a class="btn icon-btn position-relative" href="carrito.html"aria-label="Carrito">
                <i class="bi bi-cart"></i>
              </a>
            </div>
          </div>
        </div>
              <a
                class="btn icon-btn position-relative"
                href="carrito.php"
                aria-label="Carrito"
              >
                <i class="bi bi-cart"></i><span class="cart-counter"><?php echo $cart_count; ?></span>
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
              <a class="nav-link py-2" href="producto_brazaletes.php"
                >Brazaletes</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link py-2" href="productos_collares.php"
                >Collares</a
              >
            </li>
          </ul>

          <hr class="my-3" />

          <div class="d-flex justify-content-center gap-3">
            <a href="login.php"><i class="bi bi-person fs-5"></i></a>
            <a href="carrito.php" class="position-relative">
              <i class="bi bi-cart fs-5"></i>
              <span class="cart-counter"><?php echo $cart_count; ?></span>
            </a>
          </div>
        </div>
      </div>
    </header>

    <main class="cart-page">
      <section class="container-xxl py-4">
        <h1 class="h4 text-center text-uppercase fw-bold mb-2">
          Carrito de compras
        </h1>

        <?php if ($cart_count === 0): ?>

          <p class="text-center text-muted mt-4">
            Tu carrito está vacío.
          </p>
          <div class="text-center mt-3">
            <a href="index.php" class="btn btn-primary">Volver a la tienda</a>
          </div>

        <?php else: ?>

          <p class="text-center text-muted small mb-4">
            <?php echo $cart_count; ?> producto(s) en el carrito
          </p>

          <!-- Banner envío -->
          <div class="ship-banner rounded-1 p-3 mb-4">
            <i class="bi bi-truck me-2"></i>
            ¡<span class="fw-semibold">Envío gratis</span> por tu compra!
          </div>

          <div class="row g-4">
            <!-- Izquierda: productos -->
            <div class="col-lg-8">

              <!-- >= md: TABLA -->
              <div class="d-none d-md-block">
                <div class="table-responsive">
                  <table class="table align-middle mb-0 text-center">
                    <thead class="table-light align-middle">
                      <tr>
                        <th class="text-start" style="width: 45%">Producto</th>
                        <th style="width: 15%">Cantidad</th>
                        <th style="width: 15%">Precio</th>
                        <th style="width: 15%">Total</th>
                        <th style="width: 10%" class="text-center"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cart_items as $item): ?>
                      <?php
                        $id       = htmlspecialchars($item['id']);
                        $nombre   = htmlspecialchars($item['nombre']);
                        $imagen   = htmlspecialchars($item['imagen']);
                        $precio   = (float)$item['precio'];
                        $cantidad = (int)$item['cantidad'];
                        $total    = $precio * $cantidad;
                      ?>
                      <tr>
                        <!-- Producto -->
                        <td class="text-start align-middle">
                          <div class="d-flex align-items-center gap-3">
                            <?php if (!empty($imagen)): ?>
                              <img
                                src="<?php echo $imagen; ?>"
                                class="rounded"
                                alt="<?php echo $nombre; ?>"
                                width="72"
                                height="72"
                                style="object-fit:cover;"
                              />
                            <?php endif; ?>
                            <div>
                              <div class="fw-semibold"><?php echo $nombre; ?></div>
                              <!-- Podés agregar talla si la guardás en el carrito -->
                            </div>
                          </div>
                        </td>

                        <!-- Cantidad -->
                        <td class="text-center align-middle">
                          <div class="d-flex justify-content-center align-items-center">
                            <form method="POST" class="d-inline">
                              <input type="hidden" name="id" value="<?php echo $id; ?>">
                              <button class="btn btn-sm px-2 py-1" type="submit" name="decrease_qty">−</button>
                            </form>

                            <input
                              type="number"
                              readonly
                              value="<?php echo $cantidad; ?>"
                              class="form-control form-control-sm mx-1 text-center"
                              style="width: 60px;"
                            />

                            <form method="POST" class="d-inline">
                              <input type="hidden" name="id" value="<?php echo $id; ?>">
                              <button class="btn btn-sm px-2 py-1" type="submit" name="increase_qty">+</button>
                            </form>
                          </div>
                        </td>

                        <!-- Precio -->
                        <td class="align-middle text-center">
                          $ <?php echo number_format($precio, 0, ',', '.'); ?>
                        </td>

                        <!-- Total -->
                        <td class="fw-semibold align-middle text-center">
                          $ <?php echo number_format($total, 0, ',', '.'); ?>
                        </td>

                        <!-- Eliminar -->
                        <td class="text-center align-middle">
                          <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <button class="btn btn-sm text-danger" type="submit" name="remove_item" aria-label="Eliminar">
                              <i class="bi bi-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- < md: TARJETA -->
              <div class="d-md-none">
                <?php foreach ($cart_items as $item): ?>
                  <?php
                    $id       = htmlspecialchars($item['id']);
                    $nombre   = htmlspecialchars($item['nombre']);
                    $imagen   = htmlspecialchars($item['imagen']);
                    $precio   = (float)$item['precio'];
                    $cantidad = (int)$item['cantidad'];
                    $total    = $precio * $cantidad;
                  ?>
                  <div class="card border-0 border-bottom mb-3">
                    <div class="card-body pb-3">
                      <!-- Producto + eliminar -->
                      <div class="d-flex align-items-start">
                        <?php if (!empty($imagen)): ?>
                          <img src="<?php echo $imagen; ?>"
                               class="rounded me-3"
                               alt="<?php echo $nombre; ?>"
                               style="width:72px;height:72px;object-fit:cover;">
                        <?php endif; ?>
                        <div class="flex-grow-1">
                          <div class="fw-semibold"><?php echo $nombre; ?></div>
                        </div>
                        <form method="POST" class="ms-2">
                          <input type="hidden" name="id" value="<?php echo $id; ?>">
                          <button class="btn btn-sm text-danger" type="submit" name="remove_item" aria-label="Eliminar">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </div>

                      <!-- Cantidad / Precio / Total -->
                      <div class="d-flex justify-content-around align-items-center text-center mt-3">
                        <!-- Cantidad -->
                        <div>
                          <div class="small text-muted mb-1">Cantidad</div>
                          <div class="d-inline-flex align-items-center justify-content-center qty">
                            <form method="POST" class="d-inline">
                              <input type="hidden" name="id" value="<?php echo $id; ?>">
                              <button class="btn btn-sm px-2 py-1" type="submit" name="decrease_qty">−</button>
                            </form>
                            <input type="number" readonly
                                   value="<?php echo $cantidad; ?>"
                                   class="form-control form-control-sm mx-1 text-center"
                                   style="width:60px;">
                            <form method="POST" class="d-inline">
                              <input type="hidden" name="id" value="<?php echo $id; ?>">
                              <button class="btn btn-sm px-2 py-1" type="submit" name="increase_qty">+</button>
                            </form>
                          </div>
                        </div>

                        <!-- Precio -->
                        <div>
                          <div class="small text-muted mb-1">Precio</div>
                          <div class="text-nowrap">
                            $ <?php echo number_format($precio, 0, ',', '.'); ?>
                          </div>
                        </div>

                        <!-- Total -->
                        <div>
                          <div class="small text-muted mb-1">Total</div>
                          <div class="fw-semibold text-nowrap">
                            $ <?php echo number_format($total, 0, ',', '.'); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>

              <!-- Recomendados (igual que antes, estático) -->
              <hr class="my-4" />
              <h2 class="h5 text-center mb-3">Completa tu look:</h2>
              <div class="row row-cols-1 row-cols-md-3 g-3">
                <div class="col">
                  <div class="card rec-card h-100 text-center">
                    <div class="ratio ratio-4x3 rec-thumb">
                      <img
                        src="img/BRA001bracelet_fino_2.jpg"
                        class="w-100 h-100 object-fit-cover"
                        alt=""
                      />
                    </div>

                    <div class="card-body">
                      <div class="small">Brazalete Iris</div>
                      <div class="price mt-1">$ 29.000,00</div>
                    </div>
                    <div class="card-footer bg-white border-0">
                      <button class="btn btn-pink w-100">
                        AGREGAR AL CARRITO
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card rec-card h-100 text-center">
                    <div class="ratio ratio-4x3 rec-thumb">
                      <img
                        src="img/bracelet_fino_3.jpg"
                        class="w-100 h-100 object-fit-cover"
                        alt=""
                      />
                    </div>

                    <div class="card-body">
                      <div class="small">Brazalete Amelia</div>
                      <div class="price mt-1">$ 37.000,00</div>
                    </div>
                    <div class="card-footer bg-white border-0">
                      <button class="btn btn-pink w-100">
                        AGREGAR AL CARRITO
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card rec-card h-100 text-center">
                    <div class="ratio ratio-4x3 rec-thumb">
                      <img
                        src="master/aroscolagantes4.jpg"
                        class="w-100 h-100 object-fit-cover"
                        alt=""
                      />
                    </div>

                    <div class="card-body">
                      <div class="small">Aros Aura</div>
                      <div class="price mt-1">$ 47.000,00</div>
                    </div>
                    <div class="card-footer bg-white border-0">
                      <button class="btn btn-pink w-100">
                        AGREGAR AL CARRITO
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Derecha: resumen -->
            <div class="col-lg-4">
              <div class="card summary-card">
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label small fw-semibold"
                      >Cupón de descuento</label
                    >
                    <div class="input-group">
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Código"
                      />
                      <button class="btn btn-pink px-4">Añadir</button>
                    </div>
                  </div>

                  <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                      <span class="text-muted">Subtotal</span>
                      <span>
                        $ <?php echo number_format($cart_subtotal, 0, ',', '.'); ?>
                      </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                      <span class="fw-bold">Total</span>
                      <span class="fw-bold">
                        $ <?php echo number_format($cart_subtotal, 0, ',', '.'); ?>
                      </span>
                    </li>
                  </ul>

                  <!-- AGUS AGREGALO ACA -->
<a href="pedido_confirmado.php" class="btn btn-primary w-100">
  Finalizar compra
</a>



                  <!-- Vaciar carrito -->
                  <form method="POST" class="text-end mt-2">
                    <button type="submit" name="empty_cart"
                            class="btn btn-link btn-sm text-danger">
                      Vaciar carrito
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div> <!-- row -->
        <?php endif; ?>
      </section>
    </main>

    <footer class="mt-5">
      <p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
      <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="politicas.html">Política de privacidad</a>
        <a href="terminos.html">Términos y condiciones</a>
        <a href="contacto.html">Contacto</a>
      </div>
    </footer>

    <!-- Bootstrap JS -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
