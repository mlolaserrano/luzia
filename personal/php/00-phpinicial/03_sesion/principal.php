<?php
function mostrarPagina(){
  $tiempo=date('Y m d H:i:s', $_SESSION['instante']); // Formatea la fecha y hora de inicio de sesión
  $usuario=$_SESSION['usuario'];            // Obtiene el nombre de usuario de la sesión
  $tipo=$_SESSION['tipo'];                  // Obtiene el tipo de usuario de la sesión

  $pagina=<<<PAGINA
    <span>Usuario: </span><span style=color:red>{$usuario}</span> 
    <span>Tipo: </span><span style=color:red>{$tipo}</span> 
    <span>Inicio Sesion: </span><span style=color:red>{$tiempo}</span> 
    <br><a href="logout.php"> Cerrar Sesion</a>
    <br><a href="otraPagina.php"> Ir a otra página</a>
    <h3>BIENVENIDO, ESTÁS EN LA PÁGINA PRINCIPAL</h3><br/>
PAGINA;
  echo $pagina;                             // Muestra la página generada
}

function main(){
  session_start();                          // Inicia la sesión
  if( !(isset($_SESSION['usuario'])) ){   // Verifica si el usuario no está en la sesión
      header("Location: login.html");       // Redirige al usuario a la página de inicio de sesión
  }
  mostrarPagina();                          // Muestra la página principal
}
main();                                     // Llama a la función principal

?>
