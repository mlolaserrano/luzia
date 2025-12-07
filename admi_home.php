<?php 
// admi_home.php - Debe contener todo el HTML de la home
session_start();
$mensajes = "";
if(isset($_SESSION['message'])){
    $tipoAlert = isset($_SESSION['error']) && $_SESSION['error'] ? "alert-danger" : "alert-success";					
    $el_mensaje = $_SESSION['message'];
    $mensajes = <<<HTML
        <div id="upload-alert" class="alert alert-dismissible {$tipoAlert}" role="alert" style="margin-top:20px;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {$el_mensaje}
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
    <title>Administrador</title>
    <!-- Bootstrap CSS -->
    <link
      href=https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css
      rel="stylesheet"
      crossorigin="anonymous"
    />
    <!-- Bootstrap Icons -->
    <link
      href=https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css
      rel="stylesheet"
    />

    <!-- Estilos personalizados -->

    <link rel="stylesheet" href="style.css" />

 

    <!-- Tipografia -->

    <!-- Asimovian -->

    <link rel="preconnect" href=https://fonts.googleapis.com>

    <link rel="preconnect" href=https://fonts.gstatic.com crossorigin>

    <link href=https://fonts.googleapis.com/css2?family=Asimovian&display=swap rel="stylesheet">


  </head>

  <body>
   <header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid position-relative">
      <!-- Brand fijo centrado -->
      <a class="navbar-brand navbar-brand-top" href="admi_home.html">LUZIA</a>

      <!-- Toggler abre el panel derecho -->
      <button class="navbar-toggler ms-auto" type="button"
              data-bs-toggle="offcanvas" data-bs-target="#menuRight"
              aria-controls="menuRight" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menú desktop -->
      <div class="collapse navbar-collapse d-none d-lg-flex">
        <div class="d-flex ms-lg-auto">
          <a class="btn icon-btn" href="admi_inventario.html" aria-label="Inventario">
            <i class="bi bi-boxes"></i>
          </a>
          <a class="btn icon-btn" href="admi_productos.html" aria-label="Vista">
            <i class="bi bi-gear"></i>
          </a>
          <a class="btn icon-btn" href="admi_logout.html" aria-label="Salir">
            <i class="bi bi-door-open"></i>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Offcanvas móvil a la derecha -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="menuRight" aria-labelledby="menuRightLabel">
    <div class="offcanvas-header justify-content-center">
      <h5 class="offcanvas-title" id="menuRightLabel">LUZIA</h5>
      <button type="button" class="btn-close position-absolute end-0 me-3"
              data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
      <!-- Mismos iconos, en columna con texto -->
      <ul class="list-unstyled text-center w-100">
        <li class="mb-3">
          <a href="admi_inventario.html" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-boxes fs-3"></i>
            <span class="small mt-1">Inventario</span>
          </a>
        </li>
        <li class="mb-3">
          <a href="admi_productos.html" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-gear"></i>
            <span class="small mt-1">Productos</span>
          </a>
        </li>
        <li>
          <a href="admi_logout.html" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-door-open fs-3"></i>
            <span class="small mt-1">Salir</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>
<main>

 

  <!-- Carrusel -->
  <section class="container-fluid px-0">
    <div id="carouselExampleCaptions" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>

      <div class="carousel-inner">
        <!-- Slide 1, como en el home del cliente-->
        <div class="carousel-item active">
          <img src="img/banner1.jpg" class="d-block w-100" alt="Banner 1" />
          <div class="carousel-buttons">
 <button class="btn btn-modify btn-management" 
        data-bs-toggle="modal" 
        data-bs-target="#modalModificar" 
        onclick="setTargetFile('banner1.jpg')" 
        title="Modificar"> 
    <i class="bi bi-pencil"></i>
</button>

          </div>
        </div>   

        <!-- Slide 2 -->
        <div class="carousel-item">
          <img src="img/banner2.jpg" class="d-block w-100" alt="Banner 2" />
          <div class="carousel-buttons">
            
            <button class="btn btn-modify btn-management" data-bs-toggle="modal" data-bs-target="#modalModificar" title="Modificar">
              <i class="bi bi-pencil"></i>
            </button>
            
          </div>
        </div>

       

        <!-- Slide 3 -->

        <div class="carousel-item">
          <img src="img/banner_3.jpg" class="d-block w-100" alt="Banner 3" />
          <div class="carousel-buttons">
           
            <button class="btn btn-modify btn-management" data-bs-toggle="modal" data-bs-target="#modalModificar" title="Modificar">
              <i class="bi bi-pencil"></i>
            </button>
            
          </div>
        </div>
      </div>

 
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>

      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>
  </section>

  <br> <!--Para darle espacio entre bloque y bloque--> 

  <!-- Productos -->
  <article>
    <h1 class="display-4">Productos Destacados</h1>
     <div class="container py-4">
      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">

        <!-- Producto 1 -->
        <div class="col">
          <div class="card h-100">
            <div class="product-img-wrap ratio-1x1">
              <img src="img/BRA001bracelet_fino_2.jpg" class="card-img-top" alt="Producto 1">

              <!-- Botones de gestión -->
              <div class="management-buttons">
                
                <button class="btn btn-modify btn-management" data-bs-toggle="modal" data-bs-target="#modalModificar" title="Modificar">
                  <i class="bi bi-pencil"></i>
                </button>
                
              </div>           
            </div>

            <div class="card-body position-relative">

              <!-- Botones para gestionar el texto (nuevos) -->

              <h6 class="card-title text-uppercase fw-bold mb-1">Brazalete Iris</h6>

              <p class="mb-0">$29.000</p>

            </div>

          </div>

        </div>

 

         <!-- Producto 2 -->

        <div class="col">

          <div class="card h-100">

            <div class="product-img-wrap ratio-1x1">

              <img src="img/BRA002bracelet_fino_1.jpg" class="card-img-top" alt="Producto 2">

 

              <!-- Botones de gestión -->

              <div class="management-buttons">

                <button class="btn btn-modify btn-management" data-bs-toggle="modal" data-bs-target="#modalModificar" title="Modificar">

                  <i class="bi bi-pencil"></i>

                </button>

              </div>

            </div> 

            <div class="card-body position-relative">
              <h6 class="card-title text-uppercase fw-bold mb-1">Brazalete Amelia</h6>
              <p class="mb-0">$37.000</p>
            </div>
          </div>
        </div>

 

        <!-- Producto 3 -->

        <div class="col">

          <div class="card h-100">

            <div class="product-img-wrap ratio-1x1">

              <img src="img/ARO003aros1.jpg" class="card-img-top" alt="Producto 3">

 

              <!-- Botones de gestión -->

              <div class="management-buttons">
                <button class="btn btn-modify btn-management" data-bs-toggle="modal" data-bs-target="#modalModificar" title="Modificar">
                  <i class="bi bi-pencil"></i>
                </button>
              </div>
            </div>

            <div class="card-body position-relative">      
              <h6 class="card-title text-uppercase fw-bold mb-1">Aros Amaré</h6>
              <p class="mb-0">$39.000</p>
            </div>
          </div>
        </div>

        <!-- Producto 4 -->

        <div class="col">
         <div class="card h-100">
            <div class="product-img-wrap ratio-1x1">
              <img src="img/ARO001aroscolagantes3.jpg" class="card-img-top" alt="Producto 4">

              <!-- Botones de gestión -->

              <div class="management-buttons">


                <button class="btn btn-modify btn-management" data-bs-toggle="modal" data-bs-target="#modalModificar" title="Modificar">

                  <i class="bi bi-pencil"></i>

                </button>

              </div>

            </div>

 

            <div class="card-body position-relative">

              <h6 class="card-title text-uppercase fw-bold mb-1">Aros Aura</h6>

              <p class="mb-0">$47.000</p>

            </div>

          </div>

        </div>

      </div>

    </div>

  </article>

 

<!-- Contenedores de promos -->

  <article>
    <div class="container-fluid px-0">
      <div class="row g-0">
         <!-- Panel izquierdo -->
        <div class="col-12 col-md-6">
          <a href="#" class="d-block category-panel position-relative">
            <img src="img/silver.jpg" alt="aros">
            <!-- Botones de gestión -->
            <div class="management-buttons">
              
              <button class="btn btn-modify btn-management" data-bs-toggle="modal" data-bs-target="#modalModificar" title="Modificar">
                <i class="bi bi-pencil"></i>
              </button>
              
            </div>
            <span class="position-absolute top-50 start-50 translate-middle badge rounded-pill text-bg-dark px-4 py-2 fs-6">
              Silver Time
            </span>
          </a>
        </div>

        <!-- Panel derecho -->

        <div class="col-12 col-md-6">

          <a href="#" class="d-block category-panel position-relative">

            <img src="img/dorada.jpg" alt="joyeria dorada">

            <!-- Botones de gestión -->

            <div class="management-buttons">

              <button class="btn btn-modify btn-management" data-bs-toggle="modal" data-bs-target="#modalModificar" title="Modificar">

                <i class="bi bi-pencil"></i>

              </button>
            </div>
        

            <span class="position-absolute top-50 start-50 translate-middle badge rounded-pill text-bg-dark px-4 py-2 fs-6">

              Golden Time

            </span>

          </a>

        </div>

      </div>

    </div>

  </article>

 

</main>

 


<!-- Ventana para AGREGAR IMAGEN -->

<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
  <form action="upload_home.php" method="POST" enctype="multipart/form-data"> <!-- conexión con el php-->
    <div class="modal-body modal-form">
      <div class="col-md-12"> <div class="mb-3">
          <label for="fileToUpload" class="form-label">Subir Nueva Imagen</label>
          <input class="form-control" type="file" id="fileToUpload" name="fileToUpload" accept="image/*" required>
          <div class="form-text">Formatos: JPG, PNG, GIF. Máx: 5MB</div>
        </div>

        <input type="hidden" name="id_elemento" value="ID_DEL_BANNER_O_PRODUCTO_ACTUAL">
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-dark" name="submit">Guardar Cambios</button>
    </div>
  </form>
  </div>
</div>

 

<!-- modificador de imagen -->
<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="modalModificarLabel">Modificar Imagen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="upload_home.php" method="POST" enctype="multipart/form-data"> 
        
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
<!-- Footer -->

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
        // Asigna el nombre fijo del archivo a sobrescribir al campo oculto.
        // Así, PHP sabe que debe guardar la imagen como 'banner1.jpg'
        document.getElementById('id_elemento_target').value = fileName;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->

<script src=https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js crossorigin="anonymous"></script>

 

</body>

</html>