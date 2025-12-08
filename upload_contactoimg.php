<?php
session_start();

$dirUpload = "img/"; 
$maxSize = 5 * 1024 * 1024; // 5MB
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/webm']; // Incluye videos


function transferirArchivo($target_dir, $file_name, $tmp_name){
    $target_file = $target_dir . $file_name;   
    
    if (move_uploaded_file($tmp_name, $target_file)) {
        $_SESSION['message']="OK: Archivo '".$file_name."' actualizado con éxito.";
        $_SESSION['error']=FALSE;
        return true;
    } else {
        $_SESSION['message']="ERROR: No se pudo mover el archivo al directorio de destino.";
        $_SESSION['error']=TRUE;
        return false;
    }
}
// ----------------------------------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    
    // 1. Obtener el nombre fijo que viene del HTML (ej: banner1.jpg)
    $targetFileNameFixed = $_POST['id_elemento'] ?? null; 
    
    // 2. Verificar si se subió un archivo
    if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] === UPLOAD_ERR_NO_FILE) {
        $_SESSION['message'] = "Error: No se seleccionó ninguna imagen/video.";
        $_SESSION['error'] = TRUE;
    } 
    // 3. Verificar si el nombre fijo es válido
    elseif (empty($targetFileNameFixed) || $targetFileNameFixed == 'ID_DEL_BANNER_O_PRODUCTO_ACTUAL') {
        $_SESSION['message'] = "Error: El sistema no pudo identificar el elemento a modificar.";
        $_SESSION['error'] = TRUE;
    } 
    // 4. Validación de tamaño y tipo
    elseif ($_FILES['fileToUpload']['size'] > $maxSize) {
        $_SESSION['message'] = "Error: El tamaño del archivo debe ser menor a 5MB.";
        $_SESSION['error'] = TRUE;
    } elseif (!in_array($_FILES['fileToUpload']['type'], $allowedTypes)) {
        $_SESSION['message'] = "Error: Tipo de archivo no permitido.";
        $_SESSION['error'] = TRUE;
    } 
    // Ejecutar la transferencia
    else {
        transferirArchivo($dirUpload, $targetFileNameFixed, $_FILES['fileToUpload']['tmp_name']);
    }

    // Redirigir siempre de vuelta a la página de administración
    header("Location: admi_contacto.php");
    exit;
}

?>