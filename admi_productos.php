<?php 
session_start(); 

include "admi_connec.php"; // Conectamos a la BD para leer los productos

//mensaje de alerta
if(isset($_SESSION['message'])){
    $tipoAlert = $_SESSION['error'] ? "alert-danger" : "alert-success";
    echo '<div class="alert '.$tipoAlert.' alert-dismissible fade show" role="alert">
            '.$_SESSION['message'].'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['message']);
    unset($_SESSION['error']);
}
// CONSULTA PARA OBTENER PRODUCTOS REALES
$conn = conectarBDLuzia();
$sql = "SELECT * FROM producto";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Administrador | Gestión de Productos</title>
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
    <!-- NAV -->
   <header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid position-relative">
      <!-- Brand fijo centrado -->
      <a class="navbar-brand navbar-brand-top" href="admi_home.php">LUZIA</a>

      <!-- Toggler abre el panel derecho -->
      <button class="navbar-toggler ms-auto" type="button"
              data-bs-toggle="offcanvas" data-bs-target="#menuRight"
              aria-controls="menuRight" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menú desktop -->
      <div class="collapse navbar-collapse d-none d-lg-flex">
        <div class="d-flex ms-lg-auto">
          <a class="position-relative">  <?php echo $_SESSION ['nombre']." ". $_SESSION ['apellido']; ?> </a>
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
            <i class="bi bi-door-open fs-3"></i>
            <span class="small mt-1">Salir</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>


<body class="bg-light">
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold">Gestión de productos</h1>
                <p class="lead">Productos de la tienda</p>
            </div>
        </div>

        <!-- Tarjeta de acciones principales -->
<main>
  <div class="container py-3">
    <div class="row g-3">

      <div class="col-md-4">
        <div class="card text-center h-100 shadow-sm">
          <button class="btn btn-card w-100 h-100 p-0 text-reset"
                  data-bs-toggle="modal" data-bs-target="#addProductModal">
            <div class="card-body">
              <i class="bi bi-plus-circle display-4"></i>
              <h5 class="card-title mb-0">Agregar Producto</h5>
            </div>
          </button>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100 shadow-sm">
          <button class="btn btn-card w-100 h-100 p-0 text-reset"
                  data-bs-toggle="modal" data-bs-target="#editModal">
            <div class="card-body">
              <i class="bi bi-pencil display-4"></i>
              <h5 class="card-title mb-0">Modificar Producto</h5>
            </div>
          </button>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100 shadow-sm">
          <button class="btn btn-card w-100 h-100 p-0 text-reset"
                  data-bs-toggle="modal" data-bs-target="#estadoModal">
            <div class="card-body">
              <i class="bi bi-bag display-4"></i>
              <h5 class="card-title mb-0">Modificar Estado</h5>
            </div>
          </button>
        </div>
      </div>

    </div>
  </div>





        <!-- Tabla de productos -->

        <div class="card shadow">
            <div class="card-header text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"> Lista de Productos</h5>
                <span class="badge bg-light text-dark">9 productos</span>
            </div>

           <div class="card-body p-0">
                <div class="table-container">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                                                        <tr>
                                <th scope="col">Imagen</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">SKU</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Categoría</th>
                                <th scope="col" class="featured-cell">Destacado</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                            // Asegúrate de que la consulta se ejecutó y hay resultados
                                if (isset($result) && $result->num_rows > 0) { 
                                    // Recorrer cada fila de resultados 
                                    while($row = $result->fetch_assoc()){
                                    // Determinar el ícono de Destacado
                                    $destacado_icono = ($row['destacado'] == 1) ? '<i class="bi bi-star-fill text-dark"></i>': '<i class="bi bi-dash-circle text-muted"></i>';

                                    // Mostrar la fila de la tabla con los datos de PHP
                                    ?>
                                    <tr data-id="<?php echo $row['id']; ?>">
                                        <td>
                                            <img src="<?php echo $row['imagen']; ?>" class="table-img" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                                        </td>
                                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                        <td><?php echo $row['sku']; ?></td>
                                        <td><?php echo htmlspecialchars(substr($row['descripcion'], 0, 50)) . '...'; ?></td>                           
                                        <td>$<?php echo number_format($row['precio'], 0, ',', '.'); ?></td>
                                        <td><?php echo ucfirst($row['categoria']); ?></td>
                                        <td class="featured-cell"><?php echo $destacado_icono; ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                            // Mensaje si no hay productos
                            echo '<tr><td colspan="7" class="text-center">No hay productos registrados.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
        </div>
    </div>

    <!-- Ventana emergente para agregar producto -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Agregar Nuevo Producto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
    <!-- CONEXIÓN CON AGREGAR PRODUCTOS -->
                <form action="agregar_productos.php" method="POST" enctype="multipart/form-data">
                
                    <div class="modal-body">
                       <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="productImage" class="form-label">Imagen del Producto</label>
                                    <input class="form-control" type="file" id="productImage" name="imagen" accept="image/*" required>
                                    <div class="form-text">Formatos: JPG, PNG. Máx: 5MB</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Nombre del Producto</label>
                                    <input type="text" class="form-control" id="productName" name="nombre" placeholder="Ej: Anillo de Plata" required>
                                </div>
                              
                                <div class="mb-3">
                                    <label for="productSKU" class="form-label">SKU (Código único)</label>
                                    <input type="text" class="form-control" id="productSKU" name="sku" placeholder="Ej: ANI005" required>
                                </div>
                            </div>
                        </div>                      

                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="productDescription" name="descripcion" rows="3" placeholder="Describe el producto..." required></textarea>
                        </div>                     

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="productPrice" class="form-label">Precio ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="productPrice" name="precio" min="0" step="0.01" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="productStock" class="form-label">Stock</label>
                                    <input type="number" class="form-control" id="productStock" name="stock" min="1" value="10" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="productCategory" class="form-label">Categoría</label>
                                        <select class="form-select" id="productCategory" name="categoria" required>
                                            <option value="" selected disabled>Selecciona...</option>
                                            <option value="anillos">Anillos</option>
                                            <option value="collares">Collares</option>
                                            <option value="aros">Aros</option>
                                            <option value="brazaletes">Brazaletes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="productStatus" class="form-label">Estado</label>
                                        <select class="form-select" id="productStatus" name="estado" required>
                                            <option value="activo" selected>Activo (Visible)</option>
                                            <option value="pausado">Pausado (Sin Stock)</option>
                                            <option value="no publicado">No Publicado (Oculto)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>                       

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="productFeatured" name="destacado" value="1">
                            <label class="form-check-label" for="productFeatured">¿Es Producto Destacado?</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-dark">Guardar Producto</button>
                    </div>

                </form>
                </div>
        </div>
    </div>

    <!-- Ventana emergente para modificar producto -->
   <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Modificar Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
     <!-- CONEXIÓN CON EDITAR PRODUCTOS -->       
            <form action="editar_productos.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <div class="alert alert-info py-2">
                        <i class="bi bi-info-circle"></i> Selecciona un producto para cargar sus datos.
                    </div>

                    <div class="mb-4">
                        <label for="selectProductoEditar" class="form-label fw-bold">Producto a Editar:</label>
                        <select class="form-select" id="selectProductoEditar" name="id_producto" required onchange="cargarDatosProducto()">
                            <option value="" selected disabled>-- Elige un producto --</option>
                            <?php 
                            // Reiniciamos el puntero para recorrer productos desde el principio
                            if(isset($result) && $result->num_rows > 0) {
                                $result->data_seek(0);
                                while($row = $result->fetch_assoc()): 
                                ?>
                                    <option value="<?php echo $row['id']; ?>"
                                        data-nombre="<?php echo htmlspecialchars($row['nombre']); ?>"
                                        data-sku="<?php echo $row['sku']; ?>"
                                        data-desc="<?php echo htmlspecialchars($row['descripcion']); ?>"
                                        data-precio="<?php echo $row['precio']; ?>"
                                        data-stock="<?php echo $row['stock']; ?>"
                                        data-cat="<?php echo $row['categoria']; ?>"
                                        data-dest="<?php echo $row['destacado']; ?>"
                                    >
                                        <?php echo $row['sku'] . " - " . $row['nombre']; ?>
                                    </option>
                                <?php endwhile; 
                            } ?>
                        </select>
                    </div>
                    
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nueva Imagen (Opcional)</label>
                                <input class="form-control" type="file" name="imagen_nueva" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">SKU</label>
                                <input type="text" class="form-control" id="editSku" name="sku" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" id="editDesc" name="descripcion" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Precio ($)</label>
                            <input type="number" class="form-control" id="editPrecio" name="precio" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stock</label>
                            <input type="number" class="form-control" id="editStock" name="stock" required>
                        </div>

                    <div class="col-md-4">
                        <label class="form-label">Categoría</label>
                            <select class="form-select" id="editCat" name="categoria" required>
                                <option value="anillos">Anillos</option>
                                <option value="collares">Collares</option>
                                <option value="aros">Aros</option>
                                <option value="brazaletes">Brazaletes</option>
                            </select>
                        </div>
                    </div>
                    
                                        <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <select class="form-select" id="editEstado" name="estado" required>
                                <option value="activo">Activo (Visible)</option>
                                <option value="pausado">Pausado (Sin Stock)</option>
                                <option value="no publicado">No Publicado (Oculto)</option>
                            </select>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="editDest" name="destacado" value="1">
                                <label class="form-check-label" for="editDest">¿Producto Destacado?</label>
                            </div>
                        </div>
                    </div>
                </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Ventana emergente para modificar estado del producto -->

 <div class="modal fade" id="estadoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-toggle-on"></i> Cambiar Estado de Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
     <!-- CONEXIÓN CON CAMBIAR ESTADO -->       
            <form action="cambiar_estado.php" method="POST">
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Seleccionar Producto:</label>
                        <select class="form-select" id="selectProductoEstado" name="id_producto" required onchange="actualizarEstadoVisual()">
                            <option value="" selected disabled>-- Elige un producto --</option>
                            <?php 
                            
                            if(isset($result) && $result->num_rows > 0) {
                                $result->data_seek(0); 
                                while($row = $result->fetch_assoc()): 
                                ?>
                                    <option value="<?php echo $row['id']; ?>" data-estado-actual="<?php echo $row['estado']; ?>">
                                        <?php echo $row['sku'] . " - " . $row['nombre']; ?>
                                    </option>
                                <?php endwhile; 
                            } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nuevo Estado:</label>
                        <select class="form-select" name="nuevo_estado" id="inputNuevoEstado" required>
                            <option value="activo">Activo (Visible)</option>
                            <option value="pausado">Pausado (Sin Stock)</option>
                            <option value="no publicado">No Publicado (Oculto)</option>
                        </select>
                    </div>

                    <div class="alert alert-light border">
                        <small><i class="bi bi-info-circle"></i> <strong>Activo:</strong> Visible en tienda. <br>
                        <strong>Pausado:</strong> Se muestra pero no se puede comprar. <br>
                        <strong>No Publicado:</strong> Oculto totalmente.</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Actualizar Estado</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>


<footer class="mt-5 text-center">
  <p>&copy; 2024 Joyas Elegantes. Todos los derechos reservados.</p>
  <div class="d-flex flex-wrap justify-content-center gap-3">
    <a href="admi_politicas.php">Política de privacidad</a>
    <a href="admi_terminos.php">Términos y condiciones</a>
    <a href="admi_contacto.php">Contacto</a>
  </div>
</footer>

<script>
    // Función para llenar el formulario de MODIFICAR PRODUCTO
    function cargarDatosProducto() {
        // 1. Obtener el select y la opción elegida
        var select = document.getElementById('selectProductoEditar');
        var opcion = select.options[select.selectedIndex];

        // 2. Si no eligió nada, salir
        if(select.value === "") return;

        // 3. Leer los datos ocultos (data-*) y ponerlos en los inputs
        document.getElementById('editNombre').value = opcion.getAttribute('data-nombre');
        document.getElementById('editSku').value = opcion.getAttribute('data-sku');
        document.getElementById('editDesc').value = opcion.getAttribute('data-desc');
        document.getElementById('editPrecio').value = opcion.getAttribute('data-precio');
        document.getElementById('editStock').value = opcion.getAttribute('data-stock');
        document.getElementById('editCat').value = opcion.getAttribute('data-cat');
        document.getElementById('editEstado').value = opcion.getAttribute('data-estado'); // Este ya estaba en tus options!

        // 4. Marcar o desmarcar el checkbox de Destacado
        var esDestacado = opcion.getAttribute('data-dest') == "1";
        document.getElementById('editDest').checked = esDestacado;
    }

    // Función para cargar el estado actual en el modal de MODIFICAR ESTADO
    function actualizarEstadoVisual() {
        var selectProducto = document.getElementById('selectProductoEstado');
        var opcionSeleccionada = selectProducto.options[selectProducto.selectedIndex];
        var estadoActual = opcionSeleccionada.getAttribute('data-estado-actual');
        
        // Setea el select de 'Nuevo Estado' al valor actual para mayor claridad al usuario
        document.getElementById('inputNuevoEstado').value = estadoActual;
    }

    // Opcional: Ejecutar actualizarEstadoVisual al abrir el modal (para productos con estado inicial)
    document.getElementById('estadoModal').addEventListener('show.bs.modal', function () {
        // Esto asegura que si ya hay un producto seleccionado al abrir el modal, se muestre su estado.
        var select = document.getElementById('selectProductoEstado');
        if (select.value !== "") {
            actualizarEstadoVisual();
        }
    });

</script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>