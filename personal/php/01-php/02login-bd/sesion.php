<?php

session_start();

if (isset($_GET["accion"])){  
    if ($_GET["accion"]=="cerrarSesion" && isset($_SESSION['email'])){       
      cerrarSesion('email');
    }    
}

function cerrarSesion($clave){
  
  unset($_SESSION[$clave]);        // Elimina la variable clave en sesión.
  session_destroy();               // Elimina la sesion.
  header("Location: signin.html"); // Redirecciona a la página de signin. 
}

function crearSesion($clave, $valor){
    
    $_SESSION[$clave] = $valor;          // Guardar en la sesión el email del usuario.
    // header("HTTP/1.1 302 Moved Temporarily");  //REDIRRECCIÓN: https://desarrolloweb.com/articulos/redireccion-php-301-302.html 
    header("Location: principal.php");  // Redirecciono al usuario a la página principal del sitio.
}

function controlarSesion(){
// Controlo si el usuario ya está logueado en el sistema.
  $sesionUsuario=NULL;
  if(isset($_SESSION['email'])){    
    $sesionUsuario=$_SESSION['email'];
    // Le doy la bienvenida al usuario.
    //echo 'Bienvenido <strong>' . $_SESSION['email'] . '</strong>, <a href="cerrar-sesion.php">cerrar sesión</a>';
    //echo 'Bienvenido <strong>' . $_SESSION['email'] . '</strong>, <a href="sesion.php?accion=cerrarSesion">cerrar sesión</a>';
  }else{
    // Si no está logueado lo redireccion a la página de login.
    // para hacer el signin
    //header("HTTP/1.1 302 Moved Temporarily"); 
    header("Location: signin.html"); 
  }
  
  return $sesionUsuario;
}

?>