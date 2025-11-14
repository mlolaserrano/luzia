<?php

include "connec.php";     
  //session_start();

function validarLogin(){
    echo "Validar login";

    $email = $_POST['email'];       
    $clave = $_POST['clave'];
    //echo $email, $clave;
    

    // AQUI consultar a la BASE DE DATOS para ver si existe usuario y pass
    $conn = conectarBDLuzia();
    // consultar a partir de los datos obtenidos del formulario $_REQUEST['usuario']
    $resultado = consultarUsuario($conn,$email,$clave);
    //echo "Validar login";

    //$clave='Val1234**';                        // obtengo de la BD el pass correspondiente 
    $clave= $_POST['clave'];
    if ($_REQUEST['clave']==$clave){        // Verificar si la contraseña ingresada coincide con la de la BD
        
        iniciarSesion($_REQUEST['email'], $_REQUEST['clave']); // Iniciar sesión si la contraseña es correcta
    }
    else {
        header("Location: login.html");
        exit();
    }
        
}



function main(){
  // Obtengo los datos cargados en el formulario de signin.
  $email = $_POST['email'];       
  $clave = $_POST['clave'];

  // abrir conexión a base de datos, en este caso 'bd_usuario'
  //$conn = conectarBDUsuario();
    $conn = conectarBDLuzia();
    echo "Salir a BD Luzia"; 
    //echo $conn;
  // Ejecutar consulta
  //$resultado = consultarUsuario($conn,$email,$password);
  $resultado = consultarUsuario($conn,$email,$clave);
  // cerrar conexión '$conn' de base de datos
 
  if($resultado!=NULL && $resultado->num_rows>0){  
    validarLogin(); 
    //crearSesion('email', $email); // crea sesion y redirige
    //Inicia sesión y redirige index.html 
    //iniciarSesion('email', $email);

    echo "Iniciar Sesión";
  }else{ 
    echo 'El email o password es incorrecto, <a href="login.html">Vuelva a intenarlo</a>.<br/>';
  }
}
main();
?>