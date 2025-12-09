<?php
session_start();

// Logica de cambio de imagen
$mensajes = "";
if(isset($_SESSION['message'])){
    $tipoAlert = isset($_SESSION['error']) && $_SESSION['error'] ? "alert-danger" : "alert-success";
    $el_mensaje = $_SESSION['message'];
    
    // El cartelito de alerta, verde si es correcta y rojo si es error
    $mensajes = <<<HTML
        <div class="alert {$tipoAlert} alert-dismissible fade show" role="alert" style="margin-top:20px;">
            {$el_mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    HTML;
    
    unset($_SESSION['message']); 
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Administrador | Contacto</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap" rel="stylesheet">
</head>

<body>
<header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid position-relative">
      <a class="navbar-brand navbar-brand-top" href="admi_home.php">LUZIA</a>

      <button class="navbar-toggler ms-auto" type="button"
              data-bs-toggle="offcanvas" data-bs-target="#menuRight"
              aria-controls="menuRight" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse d-none d-lg-flex">
        <div class="d-flex ms-lg-auto">
          <a class="btn icon-btn" href="admi_inventario.php" aria-label="Inventario">
            <i class="bi bi-boxes"></i>
          </a>
          <a class="btn icon-btn" href="admi_home.php" aria-label="Vista">
            <i class="bi bi-eye"></i>
          </a>
          <a class="btn icon-btn" href="admi_logout.html" aria-label="Salir">
            <i class="bi bi-door-open"></i>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <div class="offcanvas offcanvas-end" tabindex="-1" id="menuRight" aria-labelledby="menuRightLabel">
    <div class="offcanvas-header justify-content-center">
      <h5 class="offcanvas-title" id="menuRightLabel">LUZIA</h5>
      <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="list-unstyled text-center w-100">
        <li class="mb-3">
          <a href="admi_inventario.php" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-boxes fs-3"></i><span class="small mt-1">Inventario</span>
          </a>
        </li>
        <li class="mb-3">
          <a href="admi_home.php" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-eye fs-3"></i><span class="small mt-1">Vista</span>
          </a>
        </li>
        <li>
          <a href="admi_logout.html" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-door-open fs-3"></i><span class="small mt-1">Salir</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>

<main>
  <div class="container">
      <?php echo $mensajes; ?>
  </div>

  <section id="contacto" class="py-5">
  <div class="container">
    <div class="row align-items-center">
      
      <div class="col-md-6 mb-4 mb-md-0">
          <div class="position-relative">
            <img src="img/contacto_banner.jpg?v=<?php echo time(); ?>" alt="Joyas Luzia banner de contacto" class="img-fluid rounded">

            <div class="management-buttons">
                <button class="btn btn-modify btn-management" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalModificar" 
                        onclick="setTargetFile('contacto_banner.jpg')" 
                        title="Modificar Imagen"> 
                    <i class="bi bi-pencil"></i>
                </button>
            </div>
          </div>
      </div>

      <div class="col-md-6">
          <h2 class="mb-3 titulo">¡Contáctanos!</h2>
          <p class="mb-4">
            No hay pregunta demasiado pequeña ni solicitud demasiado grande para nuestros asesores Luzia.
            Desde elegir un anillo de compromiso o regalo, estamos siempre a tu servicio.
          </p>

          <div class="d-flex flex-wrap gap-2 mb-3">
            <a href="tel:+5491122233344" class="btn btn-luzia">LLÁMANOS</a>
            <button type="button" class="btn btn-luzia">CONSULTANOS</button>
          </div>
          
          </div>

    </div>
  </div>
  </section>
</main>

<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalModificarLabel">Modificar Imagen</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="upload_contactoimg.php" method="POST" enctype="multipart/form-data"> 
            <div class="modal-body modal-form">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="fileToUpload" class="form-label">Subir Nueva Imagen</label>
                        <p>la imagen debera medir 1650 x 1024 px</p>
                        <input class="form-control" type="file" id="fileToUpload" name="fileToUpload" accept="image/*, video/*" required>
                        <div class="form-text">Formatos: Imágenes (JPG, PNG) o Videos. Máx: 5MB</div>
                    </div>
                </div>
                <input type="hidden" name="id_elemento" id="id_elemento_target" value="">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-dark" name="submit">Guardar Cambios</button>
            </div>
        </form>
    </div>
  </div>
</div>

<footer class="mt-5 text-center">
  <p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
  <div class="d-flex flex-wrap justify-content-center gap-3">
    <a href="admi_politicas.php">Política de privacidad</a>
    <a href="admi_terminos.php">Términos y condiciones</a>
    <a href="admi_contacto.php">Contacto</a>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
    //Script para pasar el nombre de la imagen al modal
    function setTargetFile(fileName) {
        document.getElementById('id_elemento_target').value = fileName;
    }

    //Script para ocultar la alerta automáticamente
    document.addEventListener("DOMContentLoaded", function() {
        var alerta = document.querySelector('.alert');
        if(alerta) {
            setTimeout(function() {
                var alertInstance = new bootstrap.Alert(alerta);
                alertInstance.close();
            }, 5000); // despues de 5 segundos desaparece el mensaje
        }
    });
</script>

</body>
</html>
</html>