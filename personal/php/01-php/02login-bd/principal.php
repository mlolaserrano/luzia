<?php
  include "sesion.php";
  $sesionUsuario = controlarSesion();
  
  if ($sesionUsuario!=NULL){
    // AQUI COLOCAR LA PÁGINA PRINCIPAL
    echo 'Bienvenido <strong>' . $sesionUsuario . '</strong>, <a href="sesion.php?accion=cerrarSesion">cerrar sesión</a>';

  }

?>
