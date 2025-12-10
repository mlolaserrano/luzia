<?php
session_start();

// Declarar el tipo de contenido para asegurar que el navegador lo interprete como HTML
header('Content-Type: text/html; charset=utf-8');

// Obtener el ID del pedido desde la URL, con un fallback mejorado
$id_pedido = isset($_GET['pedido']) ? htmlspecialchars($_GET['pedido']) : 'No encontrado';

// Conexión a BD para obtener el nombre (opcional pero recomendado)
require __DIR__ . '/conexion.php';

// Obtener el email del usuario logueado (si existe sesión)
$email = $_SESSION['email'] ?? null;
$nombre = "Cliente";

if ($email) {
    $stmt = $conn->prepare("
        SELECT nombre
        FROM usuario
        WHERE email = ?
        LIMIT 1
    ");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && !empty($usuario['nombre'])) {
        $nombre = $usuario['nombre'];
    }
}

// contador de carrito para el icono
$cart_count = 0;
if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $cart_count += (int)$item['cantidad'];
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pedido Confirmado | Luzia</title>  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap" rel="stylesheet" />

 <!-- Estilos específicos para esta página -->
    <style>
        :root {
            --color-primario: #b98854; 
            --color-exito: var(--color-primario); 
        }
        
        /* LAYOUT */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex-grow: 1; /*Para que el contenedor tome el espacio restante, empujando el footer */
            display: flex;
            align-items: center; 
            justify-content: center; 
            padding: 2rem 0;
        }

        /* AJUSTE DEL TAMAÑO CARD */
        .product-info {
            max-width: 750px; 
            width: 90%;
            text-align: center;
            min-height: 350px; 
            display: flex;
            flex-direction: column;
            justify-content: center; 
        }
        
        /* Estilos de contenido*/
        .alert-heading, .icon-check {
            color: var(--color-exito);
        }
        
        .alert-heading {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .icon-check {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>
  <!-- NAVBAR  -->
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
            <a class="nav-link" href="producto_brazaletes.php">Brazaletes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="productos_collares.php">Collares</a>
          </li>
        </ul>

        <!-- Derecha: email + carrito -->
        <div class="d-flex ms-lg-auto align-items-center">
          <a class="btn" href="mi_cuenta.php" aria-label="email">
            <i class="position-relative">
              <?php echo $_SESSION ['nombre']." ". $_SESSION ['apellido']; ?>
            </i>
          </a>

          <a
            class="btn icon-btn position-relative ms-2"
            href="carrito.php"
            aria-label="Carrito"
          >
            <i class="bi bi-cart"></i>
            <span class="cart-counter"><?php echo $cart_count; ?></span>
          </a>
        </div>
      </div>
    </div>
  </nav>
</header>


  <!-- CONTENIDO PRINCIPAL  -->
  <div class="main-content container text-center">
    <div class="product-info p-4 border rounded shadow-sm mt-5" role="alert">
      <!-- Ícono de confirmación -->
      <i class="bi bi-check-circle-fill icon-check"></i> 
      
      <!-- Título personalizado con el nombre -->
      <h1 class="mb-3 color-agg1">
        <?php echo htmlspecialchars($nombre); ?>, tu pedido está casi listo.
      </h1>
      
      <p class="lead mt-3 mb-4">
        Tu pedido está esperando ser procesado.
      </p>
      
      <hr>

      <!-- Mensaje -->
      <p class="texto lead mb-4">
        En breve nos estaremos comunicando vía WhatsApp con los detalles para completar el pago.
        Una vez acreditado, comenzaremos a procesar tu pedido.
      </p>
      
      <div class="btn-narrow-container">
        <a href="index.php" class="btn btn-luzia">Volver al Inicio</a>
      </div>
    </div>
  </div>

  <!-- FOOTER  -->
  <footer class="mt-5">
    <p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
    <div class="d-flex flex-wrap justify-content-center gap-3">
      <a href="politicas.html">Política de privacidad</a>
      <a href="terminos.html">Términos y condiciones</a>
      <a href="contacto.html">Contacto</a>
    </div>
  </foo
