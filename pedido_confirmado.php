<?php 
// Declarar el tipo de contenido para asegurar que el navegador lo interprete como HTML
header('Content-Type: text/html; charset=utf-8');

// Obtener el ID del pedido de la URL, si existe.
$id_pedido = isset($_GET['pedido']) ? htmlspecialchars($_GET['pedido']) : 'un momento'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>
    
    <!-- Incluye Bootstrap, Bootstrap Icons y Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" /> <!-- Tu archivo de estilos personalizado -->

    <!-- Tipografía Asimovian -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap" rel="stylesheet" />
    
    <!-- Estilos para la tarjeta de confirmación -->
    <style>
        :root {
            --color-primario: #b98854; /* Marrón elegante */
            --color-texto: #333;
            --color-fondo-claro: #fcfaf8; /* Blanco roto */
            --color-exito: var(--color-primario); 
        }

        body {
            /* Usamos la fuente Asimovian para el cuerpo si no se define en style.css */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: var(--color-fondo-claro);
            color: var(--color-texto);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Estilo para el contenido principal (la tarjeta) */
        .main-content {
            flex-grow: 1; /* Permite que el contenido principal ocupe el espacio restante */
            display: flex;
            align-items: center; /* Centra la tarjeta verticalmente */
            justify-content: center; /* Centra la tarjeta horizontalmente */
            padding: 2rem 0;
        }

        /* Estilo general de la tarjeta de confirmación */
        .alert-success {
            background-color: white; 
            border: 1px solid rgba(185, 136, 84, 0.3); 
            color: var(--color-texto); 
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08); 
            max-width: 600px;
            width: 90%;
            text-align: center;
        }
        
        .alert-heading {
            color: var(--color-exito);
            font-size: 2.2rem;
            font-weight: 700;
            margin-top: 20px;
        }

        /* Ícono grande de verificación */
        .icon-check {
            color: var(--color-exito);
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        /* Estilo para el botón Volver al Inicio (btn-success) */
        .btn-success {
            background-color: var(--color-exito);
            border-color: var(--color-exito);
            color: white; 
            padding: 10px 30px;
            border-radius: 50px; 
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(185, 136, 84, 0.4);
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-success:hover {
            background-color: #a87640; 
            border-color: #a87640;
            box-shadow: 0 6px 15px rgba(185, 136, 84, 0.6);
        }

        hr {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .lead {
            color: #666;
        }
    </style>
</head>
<body>

    <!--  navbar  -->
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid position-relative container">
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
                            <a class="nav-link" href="productos_aros.html">Aros</a>
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
                        <a class="btn icon-btn" href="login.html" aria-label="Usuario"
                            ><i class="bi bi-person"></i
                        ></a>
                        <a
                            class="btn icon-btn position-relative"
                            href="carrito.php"
                            aria-label="Carrito"
                        >
                            <i class="bi bi-cart"></i><span class="cart-counter">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Offcanvas móvil a la derecha  -->
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
                    <a href="carrito.php" class="position-relative">
                        <i class="bi bi-cart fs-5"></i>
                        <span class="cart-counter">0</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <!-- card de confirmación  -->
    <div class="main-content container text-center">
        <div class="alert alert-success p-5" role="alert">
            <!-- Ícono de confirmación -->
            <i class="bi bi-check-circle-fill icon-check"></i> 
            
            <h1 class="alert-heading">¡Tu pedido ya está casi listo!</h1>
            
            <p class="lead mt-3 mb-4">
                Tu pedido #<?php echo $id_pedido; ?> ha sido registrado con éxito.
            </p>
            
            <hr>

            <!-- Mensaje Exacto Solicitado -->
            <p class="mb-4 pt-3 fw-medium">
                En los próximos minutos recibirás un mensaje por WhatsApp con los detalles para completar el pago. <br> Una vez acreditado, comenzaremos a procesar tu pedido
            </p>
            
            <!-- Botón de acción -->
            <a href="index.html" class="btn btn-success">Volver al Inicio</a>
        </div>
    </div>

    <!-- footer-->
    <footer class="mt-5">
        <p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="politicas.html">Política de privacidad</a>
            <a href="terminos.html">Términos y condiciones</a>
            <a href="contacto.html">Contacto</a>
        </div>
    </footer>

    <!-- Script de Bootstrap (Va al final del body) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>