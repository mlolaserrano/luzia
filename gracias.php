<?php
//variables principales 

$nombre=$_REQUEST[nombre]; //esto responde a lo que se lleno 

$email=$_REQUEST[email]; 

$telefono=$_REQUEST[tel]; 

$consulta=$_REQUEST[consulta]; 

$pais=$_REQUEST[pais]; 

$micorreo=$_REQUEST[mimail]; //es el campo oculto esto es importante!! 

  

//variables internas 

$encabezado= 'From: noreplay@fulano.com.ar'; //casilla no existente; el from va tal cual en comillas simples 

$asunto = "Formulario de Contacto"; 

$cuerpo = "Nombre y Apellido: $nombre\n E-mail: $email\n Teléfono: $telefono\n Consulta: $consulta\n País: $pais"; //como recibiremos los datos del formulario 

$cuerpousu = "¡Hola, $nombre!\n Gracias por completar nuestro formulario. A continuación se copian los datos que enviastre:\n\n $cuerpo\n\n ¡¡Muchas Gracias!!"; //como se le muestra al usuario 

  

//e-mail 

mail($micorreo,$asunto,$cuerpo,$encabezado); //receptor 

mail($correo,$asunto,$cuerpousu,$encabezado); //usuario 


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

  </head>

  <body>
   <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid position-relative">
          <!-- Brand fijo centrado -->
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
                <i class="bi bi-cart"></i><span class="cart-counter">0</span>
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
              <span class="cart-counter">0</span>
            </a>
          </div>
        </div>
      </div>
    </header>


<main>
  	<div id="principal3">
	<div id="cuerpo">
	  <div class="titulo" id="titulo">Contacto</div>
		<p class="subtitulo"><span data-contrast="none" xml:lang="ES-ES" lang="ES-ES">¡Muchas Gracias! por enviar el formularo, responderemos en brevedad.</span></p>
		 <div id="formulario">
		
		 <p class="subtitulo"><span data-contrast="none" xml:lang="ES-ES" lang="ES-ES">A continuación de copiaran los siguentes datos:</span> <span data-contrast="auto" xml:lang="ES-ES" lang="ES-ES"><br>
		   </p> 

             <form action="gracias.php" method="post" name="form1" id="form1"> 

             <table width="100%" border="0" cellpadding="7" cellspacing="7"> 

                 <tbody> 

                  <tr> 

      <td align="left" valign="top" style="text-align: left"><table width="100%" border="0" cellpadding="7" cellspacing="7"> 

        <tbody> 

          <tr> 

            <td width="47%" class="negrita" style="text-align: left">Nombre y Apellido</td> 

            <td width="53%" style="text-align: left"><?php echo $nombre;?></td> 

              </tr> 

          <tr> 
			  <td class="negrita" style="text-align: left">E-mail 

              <input name="hiddenField" type="hidden" id="hiddenField" value="contacto@kelloggs.com">
              <input name="mimail" type="hidden" id="mimail" value="info@fulano.com.ar"></td> 

            <td style="text-align: left"><?php echo $email;?></td> 

           
              </tr> 

          <tr> 
             <td class="negrita" style="text-align: left">Teléfono</td> 

            <td style="text-align: left"><?php echo $telefono;?></td> 

            

              </tr> 

          <tr align="left" valign="top"> 

            <td height="114" class="negrita" style="text-align: left">Consulta</td> 

            <td style="text-align: left"><?php echo $consulta;?></td> 

              </tr> 

          <tr> 

            <td height="32" class="negrita" style="text-align: left">País</td> 

            <td style="text-align: left"><?php echo $pais;?></td> 

              </tr> 

            </tbody> 

          </table></td> 

        </tr> 

  </tbody> 

  </table> 

  </form> 


</div> 

   </div> 
		</div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

