<?php
$message = "";

// Funciones auxiliares
function getTermsData($key) {
    $file = "terms_{$key}.txt";
    return file_exists($file) ? trim(file_get_contents($file)) : '';
}

function setTermsData($key, $value) {
    $file = "terms_{$key}.txt";
    file_put_contents($file, $value);
}

$currentImage = getTermsData('image_path');

// Manejo de la subida de imagen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_image'])) {
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $error = $file['error'];
        
        // Errores de carga específicos
        if ($error !== UPLOAD_ERR_OK) {
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $message = "Error: El archivo es demasiado grande. Verifique los límites del servidor (máx. 5MB).";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $message = "Error: La subida del archivo fue parcial. Inténtelo de nuevo.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $message = "Error: No se seleccionó ninguna imagen.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                case UPLOAD_ERR_CANT_WRITE:
                case UPLOAD_ERR_EXTENSION:
                    $message = "Error: Problema interno del servidor al subir la imagen.";
                    break;
                default:
                    $message = "Error: Falló la carga de la imagen.";
                    break;
            }
        } else {
            // Continuar con la validación si no hay error de carga
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            $targetDir = "uploads/";
            
            // Asegurar que el directorio de uploads exista y sea escribible
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true); // Crear si no existe
            }
            if (!is_writable($targetDir)) {
                $message = "Error: El directorio de uploads no es escribible.";
            } elseif (!in_array($file['type'], $allowedTypes)) {
                $message = "Error: Solo se permiten JPG, PNG o GIF.";
            } elseif ($file['size'] > $maxSize) {
                $message = "Error: El tamaño del archivo debe ser menor a 5MB.";
            } else {
                $imageInfo = getimagesize($file['tmp_name']);
                if ($imageInfo === false || $imageInfo[0] != 600 || $imageInfo[1] != 400) {
                    $message = "Error: La imagen debe tener exactamente 600 px x 400 px.";
                } else {
                    $targetFile = $targetDir . basename($file['name']);
                    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                        setTermsData('image_path', $targetFile);
                        $message = "Imagen subida con éxito!";
                    } else {
                        $message = "Error: No se pudo mover la imagen al directorio de destino.";
                    }
                }
            }
        }
    } else {
        $message = "Error: No se recibió ningún archivo.";
    }
}

// Manejar eliminación de imagen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_image'])) {
    if (!empty($currentImage) && file_exists($currentImage)) {
        unlink($currentImage);
    }
    setTermsData('image_path', '');
    $message = "¡Imagen eliminada exitosamente!";
}

// Redirigir de vuelta a la página principal con mensaje
header("Location: admi_terminos.php?msg=" . urlencode($message));
exit;
?>