<?php
// ...existing code...
declare(strict_types=1);
session_start();

// ARCHIVO: carrito.php
// LÓGICA MÍNIMA REQUERIDA: Define un producto fijo y procesa la finalización.

// 1. DEFINICIÓN DE DATOS FIJOS DEL PRODUCTO
$producto_fijo = [
    'id' => 1,
    'sku' => 'ANI001',
    'nombre' => 'Anillo Aurora',
    'precio' => 53000,
    'cantidad' => 1,
    'talla' => '6',
    'imagen' => 'img/ANI001anillo_piedra_3.png'
];

// 2. CÁLCULO DE TOTALES
$subtotal = $producto_fijo['precio'] * $producto_fijo['cantidad'];
$total_productos = $producto_fijo['cantidad'];
$total_final = $subtotal;

// ID de pedido de prueba (un identificador fijo para la demostración)
$id_pedido_prueba = 101;

// 3. PROCESAMIENTO de "FINALIZAR COMPRA"
// Detecta si se hizo clic en el botón del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar_compra'])) {

    // Aquí podría guardarse en BD o en $_SESSION['pedido'] etc.
    // Uso PRG (Redirect after POST) para evitar reenvío de formulario.
    header('Location: pedido_confirmado.php?pedido=' . urlencode((string)$id_pedido_prueba));
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tu Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <!-- IMPORTANTE: Debe cargar styles.css para que el botón se vea oscuro y con margen -->
    <link rel="stylesheet" href="./styles.css">
</head>
<body>

    <div class="cart-page container my-5">
        <h2 class="titulo mb-4">Tu Carrito de Compras</h2>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($producto_fijo['nombre'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <p class="card-text">SKU: <?php echo htmlspecialchars($producto_fijo['sku'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="card-text">Talla: <?php echo htmlspecialchars($producto_fijo['talla'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="card-text">Precio unitario: $<?php echo number_format($producto_fijo['precio'], 0, ',', '.'); ?></p>
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?php echo htmlspecialchars($producto_fijo['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($producto_fijo['nombre'], ENT_QUOTES, 'UTF-8'); ?>" class="me-3" style="width:80px;height:auto;">
                            <div>
                                <div>Cantidad: <?php echo (int)$producto_fijo['cantidad']; ?></div>
                                <div class="fw-bold">Subtotal: $<?php echo number_format($subtotal, 0, ',', '.'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-card card p-3">
                    <h5 class="fw-bold mb-3">Resumen del Pedido</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Productos (<?php echo $total_productos; ?>)
                            <span class="fw-normal">$<?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                            Total Final
                            <span class="price">$<?php echo number_format($total_final, 0, ',', '.'); ?></span>
                        </li>
                    </ul>

                    <form method="POST" action="carrito.php">
                        <button type="submit" name="finalizar_compra" class="btn btn-primary w-100 mt-3">
                            Finalizar Compra
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
