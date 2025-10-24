<?php

function mostrarPagina(){
  $tiempo=date('Y m d H:i:s', $_SESSION['instante']); // Formatear la fecha y hora de inicio de sesión
  $usuario=$_SESSION['usuario'];                      // Obtener el nombre de usuario de la sesión
  $tipo=$_SESSION['tipo'];                            // Obtener el tipo de usuario de la sesión

  $pagina=<<<PAGINA
    <span>Usuario: </span><span style=color:red>{$usuario}</span> 
    <span>Tipo: </span><span style=color:red>{$tipo}</span> 
    <span>Inicio Sesion: </span><span style=color:red>{$tiempo}</span> 
    <br><a href="logout.php"> Cerrar Sesion</a>
    <br><a href="principal.php"> Volver a la página Principal</a>
    <h3>AHORA ESTÁS EN OTRA PÁGINA</h3><br/>
PAGINA;
  echo $pagina;
}

function main(){                      // Definir la función principal
  session_start();                    // Iniciar la sesión
  if(isset($_SESSION['usuario'])==FALSE){ // Verificar si la sesión del usuario no está establecida
      header("Location: login.html"); // Redirigir a la página de inicio de sesión si no hay sesión de usuario
  }
  mostrarPagina();                    // Llamar a la función mostrarPagina para mostrar la información del usuario
}
main();                               // Llamar a la función principal

?>