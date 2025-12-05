<?php
include "connec.php";
include "sesion.php";  

function iniciarSesion($email,$clave){
    // echo "Iniciar sesion";

    $_SESSION['email']  = $email;      // Guardar el nombre de usuario en la sesión
    $_SESSION['clave']  = $clave;
    header("Location: index.html"); //dirige al index
    //exit();
    //header("Location: login.html");
    //$_SESSION['email']  = $usuario1;     // Guardar el nombre de usuario en la sesión*/
}

/*
function validarLogin(){
    //echo "Validar login";

    $email = $_POST['email'];       
    $clave = $_POST['clave'];
    //echo $email, $clave;
    

    // AQUI consultar a la BASE DE DATOS para ver si existe usuario y pass
    $conn = conectarBDLuzia();
    //echo "Salir de Conectar";

    // consultar a partir de los datos obtenidos del formulario $_REQUEST['usuario']
    $resultado = consultarUsuario($conn,$email,$clave);
    echo "Salir de consultar usuario";
    return $resultado;

    //$clave='Val1234**';                        // obtengo de la BD el pass correspondiente 
    $clave= $_POST['clave'];
    if ($_REQUEST['clave']==$clave){        // Verificar si la contraseña ingresada coincide con la de la BD
        
        iniciarSesion($_REQUEST['email'], $_REQUEST['clave']); // Iniciar sesión si la contraseña es correcta
    }
    else {
        header("Location: login.html");
        exit();
    }
        
}*/


function main(){
    #Inicia la sesión
    /*if(isset($_SESSION['email'])){           // Verificar si ya hay una sesión iniciada 
        //header("Location: index.html");
        echo "Ir a mi cuenta";
        #header("Location: mi_cuenta.html");
        //header("Location: principal.php");     // Entonces hay sesion, redirigir al usuario a la página principal
        exit();
    }
    else{  */                                   // Si no hay sesión iniciada
    
        $email = $_POST['email'];      
        $clave = $_POST['clave'];
        
        //$nombre = $_POST['nombre'];

        $conn = conectarBDLuzia(); // conectar a base de datos

        $resultado = consultarUsuario($conn,$email,$clave); // Consulta usuario en la base de datos 

        #VALIDAR USUARIO
        if($resultado!=NULL && $resultado->num_rows>0){  
            //echo "Usuario válido";


            $row = mysqli_fetch_assoc($resultado); // Fetch the row as an associative array
            if ($row) { // Check if a row was returned
                
                echo "Hola " . $row['nombre'];
                //exit();
                
            } else {
                echo "Usuario no encontrado";
            }
                mysqli_free_result($resultado); // Free the result set
                cerrarBDConexion($conn);

            #SE CREA LA SESIÓN
            crearSesion('email', $email); 
            #REDIRIGE AL INDEX.HTML
            header("Location: index.html"); 
            
        }else{
            echo 'El email o clave es incorrecto, <a href="login.html">vuelva a intenarlo</a>.<br/>';
            }
    }
    /*else {
            header("Location: principal.php"); // Redirigir al usuario a la página principal
            exit();
        }         
    } */    
//}

main();                                     // Ejecutar la función principal
?>