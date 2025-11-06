<?php
function iniciarSesion($usuario,$tipo){    
    $_SESSION['usuario']  = $usuario;      // Guardar el nombre de usuario en la sesión
    $_SESSION['tipo'] = $tipo;             // Guardar el tipo de usuario en la sesión
    $_SESSION['instante']   = time();      // Guardar el instante actual en la sesión
}

function validarLogin (){
    // AQUI consultar a la BASE DE DATOS para ver si existe usuario y pass
    // consultar a partir de los datos obtenidos del formulario $_REQUEST['usuario']
    $pass='1234';                          // obtengo de la BD el pass correspondiente 
    $tipo='admin';                         // obtengo de la BD el tipo de usuario   
    if ( $_REQUEST['pass']==$pass){        // Verificar si la contraseña ingresada coincide con la de la BD
        iniciarSesion($_REQUEST['usuario'],$tipo); // Iniciar sesión si la contraseña es correcta
    }     
}

function main(){
    session_start();                           // Iniciar la sesión
    if(isset($_SESSION['usuario'])){           // Verificar si ya hay una sesión iniciada
        header("Location: principal.php");     // Entonces hay sesion, redirigir al usuario a la página principal
 
    }else{                                     // Si no hay sesión iniciada

        if (isset($_REQUEST['usuario'])&& isset($_REQUEST['pass']) ) {  // Verificar si se han enviado los datos desde formulario login.html
            validarLogin();                    // Validar usuario y contraseña
            header("Location: principal.php"); // Redirigir al usuario a la página principal
        }
    }     
}

main();                                     // Ejecutar la función principal
?>