<?php 
// Declarar el tipo de contenido para asegurar que el navegador lo interprete como HTML
header('Content-Type: text/html; charset=utf-8');

// Obtener el ID del pedido de la URL, si existe.
$id_pedido = isset($_GET['pedido']) ? htmlspecialchars($_GET['pedido']) : 'un momento'; 
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title> Anillo Aurora | Luzia</title>
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
            max-width: 750px; /* ¡Aumentado a 750px para ser más ancha! */
            width: 90%;
            text-align: center;
            /* Se añade una altura mínima para que la tarjeta no se vea "aplastada" */
            min-height: 350px; 
            display: flex;
            flex-direction: column;
            justify-content: center; /* Centra el contenido internamente si la altura es mayor */
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
        <a class="navbar-brand navbar-brand-top" href="index.html">LUZIA</a>

        <!-- Toggler abre el panel derecho -->
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuRight"
          aria-controls="menuRight" aria-label="Toggle navigation">
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
              <a class="nav-link" href="producto_brazaletes.html">Brazaletes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="productos_collares.html">Collares</a>
            </li>
          </ul>
          <div class="d-flex ms-lg-auto">
            <a class="btn icon-btn" href="login.html" aria-label="Usuario"><i class="bi bi-person"></i></a>
            <a class="btn icon-btn position-relative" href="carrito.html" aria-label="Carrito">
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
        <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="offcanvas"
          aria-label="Close"></button>
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
            <a class="nav-link py-2" href="producto_brazaletes.html">Brazaletes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link py-2" href="productos_collares.html">Collares</a>
          </li>
        </ul>

        <hr class="my-3" />

        <div class="d-flex justify-content-center gap-3">
          <a href="login.html"><i class="bi bi-person fs-5"></i></a>
          <a href="carrito.html" class="position-relative">
            <i class="bi bi-cart fs-5"></i>
            <span class="cart-counter">0</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- CONTENIDO PRINCIPAL  -->

    <div class="main-content container text-center">
        <div class="product-info p-4 border rounded shadow-sm mt-5" role="alert">
            <!-- Ícono de confirmación -->
            <i class="bi bi-check-circle-fill icon-check"></i> 
            
            <h1 class="mb-3 color-agg1">¡Tu pedido está casi listo!</h1>
            
            <p class="lead mt-3 mb-4">
                Tu pedido #<?php echo $id_pedido; ?> está esperando ser procesado.
            </p>
            
            <hr>

            <!-- Mensaje -->
            <p class=" texto lead mb-4">
                En breve recibirás un mensaje por WhatsApp con los detalles para completar el pago.
                Una vez acreditado, comenzaremos a procesar tu pedido.
            </p>
            
            <div class="btn-narrow-container">
    <a href="index.html" class="btn btn-luzia">Volver al Inicio</a>
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
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
</body>
</html>