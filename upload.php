<?php
//directorio donde se suben las imagenes a modificaer 
$dirUplod="upload/";

// extensiones válidas para la subida de las imagenes 
$extValImagen= ["jpg","png","jpeg","gif","bmp","svg"]; //Formatos permitidos y formatos de imagen
$extValVideo      = ["mp4","m4v","avi","mkv","flv","mov","mpeg","mpg","wmv","asf"]; //Formatos permitidos y formatos de video


// tamaño máximo de archivo a subir
$tamMaxArchivo = 500000; //5mb

function comprobarExtension($fileName){
    // Comprueba si la extensión de 'fileName' es válida par subir al servidor
    $checkOK = 1;    
    global $extValImagen;
     global $extValVideo;

    $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));

    $esta =in_array($fileExt,  $extValImagen)|| in_array($fileExt,  $extValVideo);

    if( !($esta) ) {       
        $_SESSION['message']="ERROR: El archivo no es del tipo aceptado.";
        $_SESSION['error']=TRUE;
        $checkOK = 0;
    }
    return $checkOK;
}

function comprobacionPrevia($target_dir,$file_name){
    // compruebaciones varias
    $checkOK = 1;
    $target_file = $target_dir . $file_name;   
    $fileTypeExtension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    global $tamMaxArchivo;
     
    // comprobar que haya una archivo seleccionado
    if($file_name==""){
        $_SESSION['message']="ERROR: Ningun archivo seleccionado.";
        $_SESSION['error']=TRUE;    
        $checkOK = 0;
    }
    // Comprobar el tamaño del archivo
    else if ($_FILES["fileToUpload"]["size"] > $tamMaxArchivo) {    
        $_SESSION['message']="ERROR: El archivo es demasiado grande.";
        $_SESSION['error']=TRUE;
        $checkOK = 0;
    }
    // Comprobar si existe el archivo
    else if (file_exists($target_file)==1) {        
        $_SESSION['message']="ERROR: El archivo ya existe.";
        $_SESSION['error']=TRUE;
        $checkOK = 0;
    }

    return $checkOK;
} 

function transferirArchivo($target_dir,$file_name){
    // tranfiere el archivo al servidor, al directorio especificdo. 
    // El archivo se encuentra en el directorio temporal del servidor y lo transfiere al directorio especificdo
    $target_file = $target_dir . $file_name;   
    $uploadOk = 1;
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $msj= "El archivo '". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). "' ha sido subido con exito.";
        $msj=$msj." Y se almacenó bajo el nombre único: '".$file_name."'.";
        $_SESSION['message']="OK: ".$msj;
        $_SESSION['error']=FALSE;

    } else {
        $msj= "Hubo un error al cargar el archivo.";
        $_SESSION['message']="ERROR: ".$msj;
        $_SESSION['error']=TRUE;
    }
    return $uploadOk;
}

function crearNombreUnicoArchivo($fileTypeExtension){
    // retorna un string para ser utilizado como nuevo nombre y único en el directorio del servidor
    // Se utiliza un nuevo nombre desde la variable sesion $_SESION['rename'].
    // Si no está seteada $_SESION['rename'], entonces se genera un string unico con md5( uniqid())
    $nuevo_nombre="";
    if (isset($_SESION['rename'])){
        $nuevo_nombre=$_SESION['rename'];
    }else{
        $nuevo_nombre = md5( uniqid()).".".$fileTypeExtension;
    }
    return $nuevo_nombre;
}


// Recomendable, utilizar la función subirArchivo para los proyectos del grupo 

function subirArchivo($target_dir,$original_file_name){
    // función principal, encargada de subir el archivo original_file_name al directorio target_dir
    // retorna NULL si no pudo subir archivo
    // retorna el arreglo arrFileName  si pudo subir con exito
    session_start();
    $arrFileName = NULL;
    $unique_file_name="";   
    
    $target_file = $target_dir . $original_file_name;   
    $fileTypeExtension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
    #chequeos
    $checkOk = comprobacionPrevia($target_dir,$original_file_name);  
    $checkOk = $checkOk && comprobarExtension($original_file_name);

    // reaaliza la transferencia si checkOk es TRUE
    if ($checkOk){          
        $unique_file_name = crearNombreUnicoArchivo($fileTypeExtension); // Renombra a un nombre único
        $uploadOk = transferirArchivo($target_dir,$unique_file_name);    //  tranfiere rchivo
        if ($uploadOk){ // si el archivo se transfirio
            $arrFileName=array($original_file_name,$unique_file_name); // preparar variable de retorno
        }
    }        
    return $arrFileName; //retorna un arreglo con el nombre achivo original y el nuevo nombre unico de archivo.
}

function activarSubida(){
    global $dirUplod;
        // ------------------------------------------------------------
        // ---- Forma de llamada para subir un archivo ----------------
        $original_file_name = basename($_FILES["fileToUpload"]["name"]);                
        subirArchivo($dirUplod,$original_file_name);
        // ------------------------------------------------------------
  
     header("Location: admi_home.html"); //conexión con admin de la home y productos 
}

function main(){
    activarSubida();
}
main();


?> 