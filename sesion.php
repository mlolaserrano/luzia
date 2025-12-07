<?php


session_start();

if (isset($_REQUEST["accion"])){  
    if ($_REQUEST["accion"]=="cerrarSesion" && isset($_SESSION['email'])){
      cerrarSesion('email');
    }    
}

function cerrarSesion($clave){
  // Elimina la variable clave en sesión.
  unset($_SESSION[$clave]); 
 
  // Elimina la sesion.
  session_destroy();
   
  // Redirecciona a la página de login. 
  header("Location: login.html");
}

function crearSesion($email, $valor){
    // Guardar en la sesión el email del usuario.
    echo "Creó sesion";
    //exit();
    $_SESSION[$email] = NULL;
    $_SESSION[$email] = $valor;
     
    // Redirecciono al usuario a la página principal del sitio.
    //header("Location: index.html"); 
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
  
    //header("HTTP/1.1 302 Moved Temporarily"); 
    session_start();
    session_destroy();
    header("Location: login.html"); 
  }
  
  return $sesionUsuario;
}

?>