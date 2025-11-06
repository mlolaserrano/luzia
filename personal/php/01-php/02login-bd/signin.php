<?php

include "bd.php";     //https://www.w3schools.com/php/php_includes.asp
include "sesion.php";
 
  
  // Obtengo los datos cargados en el formulario de login.
  $email = $_POST['email'];       //"mariano@gmail.com";
  $password = $_POST['password']; //"1234";

  // abrir conexión a base de datos, en este caso 'bd_usuario'
  $conn = conectarBD();
  // Ejecutar consulta
  $resultado = consultarUsuario($conn,$email,$password);// CHEK con base de datos
  // cerrar conexión '$conn' de base de datos
  cerrarBDConexion($conn);
  
  if($resultado!=NULL && $resultado->num_rows>0){       // verifico CHEK con base de datos
    crearSesion('email', $email); // crea sesion y redirige
  }else{
    echo 'El email o password es incorrecto, <a href="signin.html">vuelva a intenarlo</a>.<br/>';
  }
  
?>