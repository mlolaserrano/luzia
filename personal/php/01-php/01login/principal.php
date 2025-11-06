<?php
  session_start();
   
  // Controlo si el usuario ya está logueado en el sistema.
  if(isset($_SESSION['email'])){
    // COLOCAR AQUI mi pagina principal
    echo 'Bienvenido <strong>' . $_SESSION['email']. '</strong>','<a href="cerrar-sesion.php"> cerrar sesión</a>';//, <a href="cerrar-sesion.php">cerrar sesión</a>';

  }else{
    // Si no está logueado lo redireccion a la página de login.
    header("HTTP/1.1 302 Moved Temporarily"); 
    header("Location: signin.html"); 
  }


?>