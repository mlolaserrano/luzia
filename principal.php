<?php
function mostrarPagina(){
  $email=$_SESSION['email'];            // Obtiene el nombre de usuario de la sesión
$email= 'aquí estoy';
  $pagina=<<<PAGINA
    <span>Usuario: </span><span style=color:red>{$email}</span> 
    <br><a href="logout.php"> Cerrar Sesion</a>
    <br><a href="index.html"></a>
PAGINA;
  echo $pagina;                             // Muestra la página generada
}

function main(){
  session_start();                          // Inicia la sesión
 /* if( !(isset($_SESSION['email'])) ){   // Verifica si el usuario no está en la sesión
      header("Location: login.html");       // Redirige al usuario a la página de inicio de sesión
  }*/
  mostrarPagina();                          // Muestra la página principal
}
main();                                     // Llama a la función principal

?>