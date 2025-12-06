<?php
session_start();

// 1. Recoger y sanear datos
$email = htmlspecialchars($_POST['email']   ?? '', ENT_QUOTES, 'UTF-8');


// Función de ayuda para formatear precios.
function format_price(float $price): string {
    // Formatea el número: sin decimales, punto como separador de miles.
    return number_format($price, 0, ',', '.');
}


// DEFINICIÓN DE DATOS FIJOS DEL PRODUCTO
$producto_fijo = [
    'id' => 1,
    'sku' => 'ANI001',
    'nombre' => 'Anillo Aurora',
    'precio_unitario' => 53000.00, // Precio de un solo artículo
    'cantidad' => 1, // Cantidad en el carrito
    'talla' => '6',
    'imagen' => 'img/ANI001anillo_piedra_3.png'
];

// CÁLCULO DE TOTALES
$subtotal = $producto_fijo['precio_unitario'] * $producto_fijo['cantidad'];
$total_productos = $producto_fijo['cantidad'];
$total_final = $subtotal; // Asumiendo envío $0 por el banner

// ID de pedido
$id_pedido_prueba = 101;

// "FINALIZAR COMPRA"
// Detecta si se hizo clic en el botón del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar_compra'])) {

    // Aquí podría guardarse en BD o en $_SESSION['pedido'] etc.
    // Uso PRG (Redirect after POST) para evitar reenvío de formulario.
    header('Location: pedido_confirmado.php?pedido=' . urlencode((string)$id_pedido_prueba));
    exit();
}
?>

<?php
session_start();

// Inicializar carrito
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// 1) Agregar producto al carrito (viene desde la ficha)
if (isset($_POST['add_to_cart'])) {
    $id     = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = (float) $_POST['precio'];
    $talla  = $_POST['talla'];

    // Si ya existe ese producto en el carrito, sumo cantidad
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] += 1;
    } else {
        $_SESSION['carrito'][$id] = [
            'id'       => $id,
            'nombre'   => $nombre,
            'precio'   => $precio,
            'talla'    => $talla,
            'cantidad' => 1
        ];
    }
}

// 2) (Opcional) Eliminar producto
if (isset($_POST['eliminar']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    unset($_SESSION['carrito'][$id]);
}

// 3) Calcular totales
$cart_items = $_SESSION['carrito'];

$cart_count = 0;
$cart_total = 0;
foreach ($cart_items as $item) {
    $cart_count += $item['cantidad'];
    $cart_total += $item['precio'] * $item['cantidad'];
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
              
              <!-- Aquí se muestra el email del usuario -->
             
              <a class="btn" href="mi_cuenta.php" aria-label="email">
                <i class="position-relative"><?php echo $_SESSION['email'];?>></i>
              </a>
              <a class="btn icon-btn position-relative" href="carrito.html"aria-label="Carrito">
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
            <a href="login.html"><i class="bi bi-person fs-5"></i></a>
            <a href="carrito.html" class="position-relative">
              <i class="bi bi-cart fs-5"></i>
              <span class="cart-counter"><?php echo $total_productos; ?></span>
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
        <p class="text-center text-muted small mb-4">
          <?php echo $total_productos; ?> producto<?php echo $total_productos !== 1 ? 's' : ''; ?> en el carrito
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
        <tr>
          <!-- Producto: alineado a la izquierda -->
          <td class="text-start align-middle">
            <div class="d-flex align-items-center gap-3">
              <img
                src="<?php echo $producto_fijo['imagen']; ?>"
                class="rounded"
                alt="<?php echo $producto_fijo['nombre']; ?>"
                width="72"
                height="72"
              />
              <div>
                <div class="fw-semibold"><?php echo $producto_fijo['nombre']; ?></div>
                <div class="text-muted small">Talla: <?php echo $producto_fijo['talla']; ?></div>
              </div>
            </div>
          </td>

          <!-- Cantidad: centrada -->
          <td class="text-center align-middle">
            <div class="d-flex justify-content-center align-items-center">
              <button class="btn btn-sm px-2 py-1" type="button">−</button>
              <input
                type="number"
                min="1"
                value="<?php echo $producto_fijo['cantidad']; ?>"
                class="form-control form-control-sm mx-1 text-center"
                style="width: 60px;"
              />
              <button class="btn btn-sm px-2 py-1" type="button">+</button>
            </div>
          </td>

          <!-- Precio -->
          <td class="align-middle text-center">$ 53.000</td>

          <!-- Total -->
          <td class="fw-semibold align-middle text-center">$ 53.000</td>

          <!-- Eliminar -->
          <td class="text-center align-middle">
            <button class="btn btn-sm text-danger" aria-label="Eliminar">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


            <!-- < md: TARJETA -->
       <!-- Card carrito: versión mobile -->
<div class="d-md-none">
  <div class="card border-0 border-bottom mb-3">
    <div class="card-body pb-3">
      <!-- Producto + eliminar -->
      <div class="d-flex align-items-start">
        <img src="<?php echo $producto_fijo['imagen']; ?>"
             class="rounded me-3"
             alt="<?php echo $producto_fijo['nombre']; ?>"
             style="width:72px;height:72px;object-fit:cover;">
        <div class="flex-grow-1">
          <div class="fw-semibold"><?php echo $producto_fijo['nombre']; ?></div>
          <div class="small text-muted">Talla: <?php echo $producto_fijo['talla']; ?></div>
        </div>
        <button class="btn btn-sm text-danger ms-2" aria-label="Eliminar">
          <i class="bi bi-trash"></i>
        </button>
      </div>

      <!-- Cantidad / Precio / Total -->
      <div class="d-flex justify-content-around align-items-center text-center mt-3">
        <!-- Cantidad -->
        <div>
          <div class="small text-muted mb-1">Cantidad</div>
          <div class="d-inline-flex align-items-center justify-content-center qty">
            <button class="btn btn-sm px-2 py-1" type="button">−</button>
            <input type="number" min="1" value="<?php echo $producto_fijo['cantidad']; ?>"
                   class="form-control form-control-sm mx-1 text-center"
                   style="width:60px;">
            <button class="btn btn-sm px-2 py-1" type="button">+</button>
          </div>
        </div>

        <!-- Precio -->
        <div>
          <div class="small text-muted mb-1">Precio</div>
          <div class="text-nowrap">$ 53.000</div>
        </div>

        <!-- Total -->
        <div>
          <div class="small text-muted mb-1">Total</div>
          <div class="fw-semibold text-nowrap">$ 53.000</div>
        </div>
      </div>
    </div>
  </div>
</div>


            <!-- Recomendados -->
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
                    <span class="text-muted">Subtotal</span
                    ><span>$ 53.000</span>
                  </li>
                 
                  <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Total</span
                    ><span class="fw-bold">$ 53.000</span>
                  </li>
                </ul>

                                
                              
                                <form method="POST" action="carrito.php">
                                  
                                  <input type="hidden" name="finalizar_compra" value="1">
                                
                                  <button type="submit" class="btn btn-primary w-100">
                                    Finalizar Compra
                                  </button>
                                </form>
            
              </div>
            </div>

         
          </div>
        </div>
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