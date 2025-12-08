<?php
session_start();
include "connec.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recibir datos
    $id = $_POST['id_producto'];
    $nuevo_estado = $_POST['nuevo_estado'];

    //  Conectar
    $conn = conectarBDLuzia();

    // Actualizar solo el estado
    $sql = "UPDATE producto SET estado = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // 'si' -> string (estado), integer (id)
    $stmt->bind_param("si", $nuevo_estado, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Estado actualizado correctamente.";
        $_SESSION['error'] = false;
    } else {
        $_SESSION['message'] = "Error al actualizar estado: " . $stmt->error;
        $_SESSION['error'] = true;
    }

    $stmt->close();
    cerrarBDConexion($conn);

    //  Volver a la lista
    header("Location: admi_productos.php");
    exit();
}
?>