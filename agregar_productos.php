<?php
session_start();
include "connec.php"; // conección con la Base de Datos

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Captura los datos del forms
    $nombre = $_POST['nombre'];
    $sku = $_POST['sku'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock']; 
    $estado = isset($_POST['estado']) ? $_POST['estado'] : 'activo';
    
    // Manejo del Checkbox (Si está marcado es 1, sino 0)
    $destacado = isset($_POST['destacado']) ? 1 : 0;
    
    // Estado por defecto
    $estado = 'activo';

    // Manejo de las imagenes
    $dir_subida = 'img/'; // Carpeta destino
    $nombre_archivo = basename($_FILES['imagen']['name']);
    
    // Se genera un SKU 
    $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
    $nombre_final_imagen = $sku . '.' . $extension;
    $ruta_destino = $dir_subida . $nombre_final_imagen;
    
    // Validaciones básicas de imagen
    $uploadOk = 1;
    $tipo_imagen = strtolower(pathinfo($ruta_destino, PATHINFO_EXTENSION));
    
    // Intentar subir la imagen
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
        
        // Insert en BD
        $conn = conectarBDLuzia(); 

        // La columna 'imagen' guarda la RUTA del archivo
        $sql = "INSERT INTO producto (sku, nombre, descripcion, categoria, precio, stock, imagen, destacado, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssssdisss", $sku, $nombre, $descripcion, $categoria, $precio, $stock, $ruta_destino, $destacado, $estado);

        if ($stmt->execute()) {
            $_SESSION['message'] = "¡Producto agregado exitosamente!";
            $_SESSION['error'] = false;
        } else {
            $_SESSION['message'] = "Error al guardar en BD: " . $stmt->error;
            $_SESSION['error'] = true;
        }

        $stmt->close();
        cerrarBDConexion($conn);

    } else {
        $_SESSION['message'] = "Error al subir la imagen.";
        $_SESSION['error'] = true;
    }

    //lo llevamos al admi_productos
    header("Location: admi_productos.php");
    exit();
}
?>