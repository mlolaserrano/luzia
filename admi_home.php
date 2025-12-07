<?php 
// 1. BLOQUE PHP PARA MANEJO DE SESIÓN Y MENSAJES
// Este código debe estar al inicio para poder mostrar la alerta después de una subida.
session_start();
$mensajes = "";
if(isset($_SESSION['message'])){
    // Si hay un error, usa alert-danger, si no, usa alert-success
    $tipoAlert = isset($_SESSION['error']) && $_SESSION['error'] ? "alert-danger" : "alert-success";					
    $el_mensaje = $_SESSION['message'];
    
    // Crea el bloque HTML de la alerta con Bootstrap 5
    $mensajes = <<<HTML
        <div id="upload-alert" class="alert alert-dismissible {$tipoAlert}" role="alert" style="margin-top:20px;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {$el_mensaje}
        </div>
    HTML;
    
    // Limpiamos las variables de sesión para que el mensaje no se repita al recargar
    unset($_SESSION['message']); 
    unset($_SESSION['error']);
}

// Puedes incluir la conexión a la base de datos aquí si la necesitas después.
// include "connec.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Administrador</title>
    <link href=https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css rel="stylesheet" crossorigin="anonymous"/>
    <link href=https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css rel="stylesheet"/>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href=https://fonts.googleapis.com>
    <link rel="preconnect" href=https://fonts.gstatic.com crossorigin>
    <link href=https://fonts.googleapis.com/css2?family=Asimovian&display=swap rel="stylesheet">
</head>

<body>
   <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid position-relative">
            <a class="navbar-brand mx-auto" href="#">
                <img src="img/logo_home.png" alt="Logo" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admi_home.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admi_productos.html">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admi_pedidos.html">Pedidos</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Salir <i class="bi bi-box-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
  </header>
    
    <main class="container mt-4">
        <h2>Panel de Administración de Home</h2>
        
        <?php echo $mensajes; ?> 

        <section class="mb-5">
            <h3>Carrusel Principal</h3>
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/banner1.jpg" class="d-block w-100" alt="Slide 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Banner 1</h5>
                            <button class="btn btn-modify btn-management" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalModificar" 
                                    onclick="setTargetFile('banner1.jpg')" 
                                    title="Modificar"> 
                                <i class="bi bi-pencil"></i>
                            </button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/banner2.jpg" class="d-block w-100" alt="Slide 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Banner 2</h5>
                            <button class="btn btn-modify btn-management" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalModificar" 
                                    onclick="setTargetFile('banner2.jpg')" 
                                    title="Modificar"> 
                                <i class="bi bi-pencil"></i>
                            </button>
                        </div>
                    </div>
                </div>
                </div>
        </section>

        <section class="mb-5">
            <h3>Productos Destacados</h3>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="img/BRA001bracelet_fino_2.jpg" class="card-img-top" alt="Producto 1">
                        <div class="card-body">
                            <h5 class="card-title">Pulsera de Plata Fina</h5>
                            <button class="btn btn-modify btn-management" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalModificar" 
                                    onclick="setTargetFile('BRA001bracelet_fino_2.jpg')" 
                                    title="Modificar"> 
                                <i class="bi bi-pencil"></i>
                            </button>
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

          <form action="procesar_upload.php" method="POST" enctype="multipart/form-data"> 
            
            <div class="modal-body modal-form">
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="fileToUpload" class="form-label">Subir Nueva Imagen</label>
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
        <a href="admi_politicas.html">Política de privacidad</a>
        <a href="admi_terminos.html">Términos y condiciones</a>
        <a href="admi_contacto.html">Contacto</a>
      </div>
    </footer>
     
    <script>
        function setTargetFile(fileName) {
            // Asigna el nombre fijo del archivo (ej: 'banner1.jpg') al campo oculto del modal
            document.getElementById('id_elemento_target').value = fileName;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>