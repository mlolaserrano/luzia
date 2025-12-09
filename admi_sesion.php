<?php


session_start();

function crearSesion($email, $valor){
    // Guardar en la sesión el email del usuario.
    //echo "Creó sesion";
    //exit();
    $_SESSION[$email] = NULL;
    $_SESSION[$email] = $valor;
     
    
}

function controlarSesion(){
// Controlo si el usuario ya está logueado en el sistema.
  $sesionUsuario=NULL;
  if(isset($_SESSION['email'])){
    // Le asigno la sesion correspondiente al usuario
    
    //echo "Logeado" . $_SESSION['email'];
    //session_destroy();
    //exit();
    $sesionUsuario=$_SESSION['email']; 
    
    header("Location:detalle_producto.php"); //Hacia acá se redirigirá
    
    
  }else{

    // Si no está logueado lo redireccion a la página de login.  

    session_start();
    session_destroy();
    header("Location: login.html"); 
  }
  
  return $sesionUsuario;
}

?>