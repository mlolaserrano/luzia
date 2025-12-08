<?php
session_start();
include "connec.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Recibir ID y datos básicos
    $id = $_POST['id_producto']; // Viene del Select
    $nombre = $_POST['nombre'];
    $sku = $_POST['sku'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];
    $estado = $_POST['estado'];
    $destacado = isset($_POST['destacado']) ? 1 : 0;

    $conn = conectarBDLuzia();

    //Verificar si subieron una NUEVA imagen
    $imagen_nueva = $_FILES['imagen_nueva']['name'];

    if ($imagen_nueva != "") {
        // SI subieron imagen, actualizamos todo INCLUYENDO la ruta de imagen
        
        $dir_subida = 'img/';
        $extension = strtolower(pathinfo($imagen_nueva, PATHINFO_EXTENSION));
        // Mantenemos el nombre basado en SKU para orden
        $nombre_final_imagen = $sku . '.' . $extension; 
        $ruta_destino = $dir_subida . $nombre_final_imagen;

        if (move_uploaded_file($_FILES['imagen_nueva']['tmp_name'], $ruta_destino)) {
            
            $sql = "UPDATE producto SET 
                    sku=?, nombre=?, descripcion=?, categoria=?, precio=?, stock=?, imagen=?, destacado=?, estado=? 
                    WHERE id=?";
            
            $stmt = $conn->prepare($sql);
            // ssssdisssi (imagen es string, id es int al final)
            $stmt->bind_param("ssssdisssi", $sku, $nombre, $descripcion, $categoria, $precio, $stock, $ruta_destino, $destacado, $estado, $id);
            
        } else {
            $_SESSION['message'] = "Error al subir la nueva imagen.";
            $_SESSION['error'] = true;
            header("Location: admi_productos.php");
            exit();
        }

    } else {
        // NO subieron imagen, actualizamos todo MENOS la imagen
        
        $sql = "UPDATE producto SET 
                sku=?, nombre=?, descripcion=?, categoria=?, precio=?, stock=?, destacado=?, estado=? 
                WHERE id=?";
        
        $stmt = $conn->prepare($sql);
        // sssdissi (sin imagen)
        $stmt->bind_param("ssssdissi", $sku, $nombre, $descripcion, $categoria, $precio, $stock, $destacado, $estado, $id);
    }

    //Ejecutar la consulta
    if ($stmt->execute()) {
        $_SESSION['message'] = "Producto actualizado correctamente.";
        $_SESSION['error'] = false;
    } else {
        $_SESSION['message'] = "Error al actualizar: " . $stmt->error;
        $_SESSION['error'] = true;
    }

    $stmt->close();
    cerrarBDConexion($conn);

    header("Location: admi_productos.php");
    exit();
}
?>