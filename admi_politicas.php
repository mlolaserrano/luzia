<?php
// Helper functions for reading/writing text files
function getPolicyData($key) {
    $file = "policy_{$key}.txt";
    return file_exists($file) ? trim(file_get_contents($file)) : '';
}

function setPolicyData($key, $value) {
    $file = "policy_{$key}.txt";
    file_put_contents($file, $value);
}

// Cargar datos actuales desde archivos
$currentTitle = getPolicyData('title') ?: '¡Estamos en construcción!';
$currentDescription = getPolicyData('description') ?: 'Lamentamos los inconvenientes. Nuestros politicas de privacidad estan siendo actualizadas.';
$currentImage = getPolicyData('image_path');
$message = "";

// Handle message from GET (e.g., from upload redirect)
if (isset($_GET['msg'])) {
    $message = urldecode($_GET['msg']);
}

// Handle text save (from modalTexto)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_text'])) {
    $newTitle = $_POST['policy_title'];
    $newDescription = $_POST['policy_description'];
    setPolicyData('title', $newTitle);
    setPolicyData('description', $newDescription);
    $currentTitle = $newTitle;
    $currentDescription = $newDescription;
    $message = "¡Texto actualizado exitosamente!";  // UPDATED: Now in Spanish
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Administrador | Políticas de Privacidad </title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css" />

  <!-- Tipografía -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap" rel="stylesheet">
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
          <a class="btn icon-btn" href="admi_inventario.php" aria-label="Inventario">
            <i class="bi bi-boxes"></i>
          </a>
          <a class="btn icon-btn" href="admi_home.php" aria-label="Vista">
            <i class="bi bi-eye"></i>
          </a>
          <a class="btn icon-btn" href="admi_logout.php" aria-label="Salir">
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
          <a href="admi_home.html" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-eye fs-3"></i>
            <span class="small mt-1">Vista</span>
          </a>
        </li>
        <li>
          <a href="admi_logout.html" class="d-flex flex-column align-items-center text-decoration-none">
            <i class="bi bi-door-open"></i>
            <span class="small mt-1">Salir</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>

<main>
  <section id="contacto" class="py-5">
  <div class="container">
    <!-- Display message alert if present -->
    <?php if (!empty($message)): ?>
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($message); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="row align-items-center">
      
      <!-- Columna de Imagen + Panel de Administración -->
      <div class="col-md-6 mb-4 mb-md-0">
  <div class="position-relative">
    <img src="<?php echo !empty($currentImage) ? $currentImage : 'img/construccion.gif'; ?>" alt="osito en proceso" class="img-fluid rounded">

    <!-- Botones sobre la imagen -->
    <div class="position-absolute top-0 start-0 w-100 px-3 py-3 d-flex justify-content-start mx-2 gap-2">
      <button class="btn btn-add btn-management" data-bs-toggle="modal" data-bs-target="#modalAgregar" title="Agregar">
              <i class="bi bi-plus-lg"></i>
            </button>
      <button class="btn btn-delete btn-management" data-bs-toggle="modal" data-bs-target="#modalEliminar" title="Eliminar">
        <i class="bi bi-trash"></i>
      </button>
    </div>
  </div>
</div>
<!-- Mod Agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarLabel">Agregar Imagen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" action="upload_politicas.php">
          <small class="form-text">Formatos permitidos: JPG, PNG, GIF. Máx: 5MB</small>
          <br>
          <small class="form-text">La imagen debe de medir 600px x 400px</small>
          <br>
          <br>
          <input type="file" class="form-control" name="image" accept="image/*" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-luzia" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" name="upload_image" class="btn btn-luzia">Agregar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Mod Eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEliminarLabel">Eliminar Imagen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 2rem;"></i>
        <p class="mt-3">¿Estás segura de que querés eliminar esta imagen?</p>
        <div class="alert alert-warning">Esta acción no se puede deshacer.</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-luzia" data-bs-dismiss="modal">Cancelar</button>
        <form method="POST" action="upload_politicas.php" style="display: inline;">
          <button type="submit" name="delete_image" class="btn btn-luzia">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>


      <!--  Columna de Texto y Botones de contacto -->
  <div class="col-md-6 text-center">
            <h1 class="mb-3 color-agg1"><?php echo htmlspecialchars($currentTitle); ?></h1>
            <hr>
            <p class=" texto lead mb-4">
              <?php echo nl2br(htmlspecialchars($currentDescription)); ?>
            </p>
            <a href="index.html" class="btn btn-luzia">
              Volver al inicio
            </a>
            <br>
             <!--Panel de administración -->
 <div class="d-flex flex-wrap gap-2 justify-content-center py-3">
  <button class="btn btn-modify btn-management" data-bs-toggle="modal" data-bs-target="#modalTexto" title="Modificar texto">
    <i class="bi bi-pencil-square"></i>
  </button>
</div>
          </div>
<!--mod de texto-->
    <div class="modal fade" id="modalTexto" tabindex="-1" aria-labelledby="modalTextoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTextoLabel">Modificar Texto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <label class="form-label">Título</label>
          <input type="text" class="form-control mb-3" name="policy_title" value="<?php echo htmlspecialchars($currentTitle); ?>" required>
          <label class="form-label">Descripción</label>
          <textarea class="form-control" name="policy_description" rows="4" required><?php echo htmlspecialchars($currentDescription); ?></textarea>
      </div>
      <div class="modal-footer">
        <button type="submit" name="save_text" class="btn btn-luzia">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>


    </div>
  </div>
</section>

 
</main>

<footer class="mt-5 text-center">
  <p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
  <div class="d-flex flex-wrap justify-content-center gap-3">
    <a href="admi_politicas.php">Política de privacidad</a>
    <a href="admi_terminos.php">Términos y condiciones</a>
    <a href="admi_contacto.php">Contacto</a>
  </div>
</footer>
</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</html>