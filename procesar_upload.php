<?php
// procesar_upload.php

session_start();
// NOTA: Aquí van todas las funciones auxiliares (comprobarExtension, comprobacionPrevia, transferirArchivo, etc.)
// ...

function transferirArchivo($target_dir, $file_name){
    // Ajuste CRÍTICO: Si el archivo ya existe (comprobado en comprobacionPrevia, pero esta función lo mueve),
    // Move_uploaded_file sobrescribirá el archivo si tiene el mismo nombre, lo que queremos.
    $target_file = $target_dir . $file_name;   
    $uploadOk = 1;
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // ... (Mensajes de éxito) ...
        $_SESSION['message']="OK: El archivo ha sido subido con éxito y guardado como '".$file_name."'.";
        $_SESSION['error']=FALSE;

    } else {
        // ... (Mensajes de error) ...
        $_SESSION['message']="ERROR: Hubo un error al cargar el archivo.";
        $_SESSION['error']=TRUE;
        $uploadOk = 0;
    }
    return $uploadOk;
}


// AÑADIMOS $use_unique_name para controlar si renombramos o no.
function subirArchivo($target_dir, $file_name_target, $use_unique_name){
    
    $original_file_name = basename($_FILES["fileToUpload"]["name"]);
    $fileTypeExtension = strtolower(pathinfo($original_file_name,PATHINFO_EXTENSION));

    // 1. Chequeos (usamos el nombre original para chequeos de extensión y el tamaño)
    $checkOk = comprobacionPrevia($target_dir, $original_file_name);  
    $checkOk = $checkOk && comprobarExtension($original_file_name);

    if ($checkOk){          
        $final_name = $file_name_target;
        
        // 2. Decide si usar nombre único o el nombre fijo (banner1.jpg)
        if ($use_unique_name) {
            $final_name = crearNombreUnicoArchivo($fileTypeExtension); 
        }

        // 3. Transferir el archivo
        $uploadOk = transferirArchivo($target_dir, $final_name);    
        
        if ($uploadOk){
            $arrFileName = array($original_file_name, $final_name);
            return $arrFileName;
        }
    }        
    return NULL;
}


function main(){
    session_start();
    
    // CONFIGURACIÓN: ASUME que las imágenes están en la carpeta 'img/'
    $dirUplod = "img/"; 
    
    // El nombre que viene del campo oculto (ej: 'banner1.jpg')
    $target_file_name = $_POST['id_elemento'] ?? null; 
    
    // El archivo subido originalmente por el usuario
    $original_file_name = basename($_FILES["fileToUpload"]["name"]);
    
    $arrArchivos = NULL;

    // LÓGICA: Si viene un ID_ELEMENTO, usamos el nombre de archivo fijo para sobrescribir
    if ($target_file_name && $target_file_name !== 'ID_ACTUAL_DEL_PRODUCTO_O_BANNER') {
        
        // Sobrescribir: NO USAR nombre único (false)
        $arrArchivos = subirArchivo($dirUplod, $target_file_name, false); 
        
    } else {
        // Es un archivo NUEVO: Usar el nombre de archivo del usuario y crear nombre único (true)
        $arrArchivos = subirArchivo($dirUplod, $original_file_name, true); 
    }

    // Redirigir siempre de vuelta a la Home para mostrar el mensaje
    header("Location: admi_home.php"); 
    exit(); 
}

main();
?>