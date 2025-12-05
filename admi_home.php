<?php 
// admi_home.php

session_start();
$mensajes = "";
if(isset($_SESSION['message'])){
    // Si hay un error, usa alert-danger, si no, usa alert-success
    $tipoAlert = isset($_SESSION['error']) && $_SESSION['error'] ? "alert-danger" : "alert-success";					
    $el_mensaje = $_SESSION['message'];
    
    // Crea el bloque HTML del mensaje
    $mensajes = <<<HTML
        <div id="upload-alert" class="alert alert-dismissible {$tipoAlert}" role="alert" style="margin-top:20px;">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {$el_mensaje}
        </div>
    HTML;
    
    // Limpiamos las variables de sesión para que el mensaje no se repita
    unset($_SESSION['message']); 
    unset($_SESSION['error']);
}

// Aquí podrías incluir la conexión a la base de datos si la necesitaras para mostrar productos dinámicamente
// include "connec.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    </head>
<body>
    <header>
        </header>
    
    <main>
        <div class="container">
            <?php echo $mensajes; ?> 
        </div>
        
        </main>
    </body>
</html>