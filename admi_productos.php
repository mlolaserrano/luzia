<?php 
session_start(); 
include "admi_connec.php"; //conec de la bd 
$mensajes = "";
if(isset($_SESSION['message'])){
    $tipoAlert = isset($_SESSION['error']) && $_SESSION['error'] ? "alert-danger" : "alert-success";
    $el_mensaje = $_SESSION['message'];
    
    // Construcción del cartel de alerta
    $mensajes = <<<HTML
        <div class="alert {$tipoAlert} alert-dismissible fade show" role="alert" style="margin-top: 20px;">
            {$el_mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    HTML;
    unset($_SESSION['message']);
    unset($_SESSION['error']);
}

// Consulta a Base de Datos 
$conn = conectarBDLuzia();
$sql = "SELECT * FROM producto";
$result = $conn->query($sql);
$num_productos = (isset($result) && $result) ? $result->num_rows : 0;
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Administrador | Gestión de Productos</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      crossorigin="anonymous"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Asimovian&display=swap"
      rel="stylesheet"
    />
  </head>
  
  <body>
    <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid position-relative">
          <a class="navbar-brand navbar-brand-top" href="admi_home.php">LUZIA</a>
          <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuRight" aria-controls="menuRight" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse d-none d-lg-flex">
            <div class="d-flex ms-lg-auto align-items-center gap-3">
              <span class="text-muted d-none d-xl-block"><?php echo $_SESSION['nombre'] ?? ''; ?></span>
              <a class="btn icon-btn" href="admi_inventario.php" aria-label="Inventario"><i class="bi bi-boxes"></i></a>
              <a class="btn icon-btn" href="admi_home.php" aria-label="Vista"><i class="bi bi-eye"></i></a>
              <a class="btn icon-btn" href="admi_logout.php" aria-label="Salir"><i class="bi bi-door-open"></i></a>
            </div>
          </div>
        </div>
      </nav>
      </header>

    <main class="bg-light">
      <div class="container py-4">

        <?php echo $mensajes; ?> 

        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold">Gestión de Productos</h1>
                <p class="lead">Inventario y acciones de la tienda</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card text-center h-100 shadow-sm">
                    <button class="btn btn-card w-100 h-100 p-3 text-reset" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <div class="card-body">
                            <i class="bi bi-plus-circle display-4 text"></i>
                            <h5 class="card-title mt-2">Agregar Producto</h5>
                        </div>
                    </button>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center h-100 shadow-sm">
                    <button class="btn btn-card w-100 h-100 p-3 text-reset" data-bs-toggle="modal" data-bs-target="#editModal">
                        <div class="card-body">
                            <i class="bi bi-pencil display-4 text"></i>
                            <h5 class="card-title mt-2">Modificar Producto</h5>
                        </div>
                    </button>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center h-100 shadow-sm">
                    <button class="btn btn-card w-100 h-100 p-3 text-reset" data-bs-toggle="modal" data-bs-target="#estadoModal">
                        <div class="card-body">
                            <i class="bi bi-toggle-on display-4 text"></i>
                            <h5 class="card-title mt-2">Modificar Estado</h5>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card shadow">
            <div class="card-header text-white bg-dark d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Lista de Productos</h5>
                <span class="badge bg-light text-dark"><?php echo $num_productos; ?> productos</span>
            </div>

           <div class="card-body p-0">
                <div class="table-container">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Imagen</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">SKU</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Dest.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if (isset($result) && $result->num_rows > 0) { 
                                    $result->data_seek(0);
                                    while($row = $result->fetch_assoc()){
                                    // Variables de íconos y formato
                                    $destacado_icono = ($row['destacado'] == 1) ? '<i class="bi bi-star-fill text-warning"></i>': '<i class="bi bi-dash-circle text-muted"></i>';
                                    $estado_clase = ($row['estado'] == 'activo') ? 'bg-success' : (($row['estado'] == 'pausado') ? 'bg-warning text-dark' : 'bg-secondary');
                                    ?>
                                    <tr data-id="<?php echo $row['id']; ?>">
                                        <td><?php echo $row['id']; ?></td>
                                        <td>
                                            <img src="<?php echo $row['imagen']; ?>?v=<?php echo time(); ?>" class="table-img" style="width: 50px; height: 50px; object-fit: cover;" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                                        </td>
                                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                        <td><?php echo $row['sku']; ?></td>
                                        <td>$<?php echo number_format($row['precio'], 0, ',', '.'); ?></td>
                                        <td><?php echo $row['stock']; ?></td>
                                        <td><?php echo ucfirst($row['categoria']); ?></td>
                                        <td><span class="badge <?php echo $estado_clase; ?>"><?php echo ucfirst($row['estado']); ?></span></td>
                                        <td><?php echo $destacado_icono; ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                            echo '<tr><td colspan="9" class="text-center">No hay productos registrados.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Agregar Nuevo Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
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

                        <div class="col-md-4">
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
                    </div>                       

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="productFeatured" name="destacado" value="1">
                                <label class="form-check-label" for="productFeatured">¿Es Producto Destacado?</label>
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Guardar Producto</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Modificar Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
                                        data-estado="<?php echo $row['estado']; ?>"
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="estadoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-toggle-on"></i> Cambiar Estado de Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
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
        var select = document.getElementById('selectProductoEditar');
        var opcion = select.options[select.selectedIndex];
        if(select.value === "") return;

        document.getElementById('editNombre').value = opcion.getAttribute('data-nombre');
        document.getElementById('editSku').value = opcion.getAttribute('data-sku');
        document.getElementById('editDesc').value = opcion.getAttribute('data-desc');
        document.getElementById('editPrecio').value = opcion.getAttribute('data-precio');
        document.getElementById('editStock').value = opcion.getAttribute('data-stock');
        document.getElementById('editCat').value = opcion.getAttribute('data-cat');
        document.getElementById('editEstado').value = opcion.getAttribute('data-estado'); 

        var esDestacado = opcion.getAttribute('data-dest') == "1";
        document.getElementById('editDest').checked = esDestacado;
    }

    // Función para cargar el estado actual en el modal de MODIFICAR ESTADO
    function actualizarEstadoVisual() {
        var selectProducto = document.getElementById('selectProductoEstado');
        var opcionSeleccionada = selectProducto.options[selectProducto.selectedIndex];
        var estadoActual = opcionSeleccionada.getAttribute('data-estado-actual');
        
        document.getElementById('inputNuevoEstado').value = estadoActual;
    }

    // Opcional: Ejecutar actualizarEstadoVisual al abrir el modal
    document.getElementById('estadoModal').addEventListener('show.bs.modal', function () {
        var select = document.getElementById('selectProductoEstado');
        if (select.value !== "") {
            actualizarEstadoVisual();
        }
    });

    // Alerta que desaparece después de 5 segundos
    document.addEventListener("DOMContentLoaded", function() {
        var alerta = document.querySelector('.alert');
        if(alerta) {
            setTimeout(function() {
                var alertInstance = new bootstrap.Alert(alerta);
                alertInstance.close();
            }, 5000); 
        }
    });
</script>

<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
  crossorigin="anonymous"
></script>
  </body>
</html>