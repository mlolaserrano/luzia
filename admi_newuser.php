<?php
include "admi_connec.php";  


function obtenerDatos($nombre, $apellido,$dni, $email, $telefono, $clave, $confirmarClave){
    $_SESSION['dni']            = $dni;
    $_SESSION['nombre']         = $nombre;
    $_SESSION['apellido']       = $apellido;
    $_SESSION['email']          = $email;      // Guardar el nombre de usuario en la sesión
    $_SESSION['telefono']       = $telefono;
    $_SESSION['clave']          = $clave;
    $_SESSION['confirmarClave'] = $confirmarClave;
    
    exit();
}


function main(){
    $nombre         = $_POST['nombre'];
    $apellido       = $_POST['apellido'];
    $dni            = $_POST['dni'];
    $email          = $_POST['email'];  
    $telefono       = $_POST['telefono'];    
    $clave          = $_POST['clave'];
    $confirmarClave = $_POST['confirmarClave'];


    #CONECTAR BD
    $conn = conectarBDLuzia();

    #VALIDACIÓN DNI
    $resultado = validarDni($conn,$dni);
    
    if($resultado!=NULL && $resultado->num_rows>0){  
        //echo "El DNI ya existe";
        header("Location: admi_login.html");
        exit();
    
    }
    else{
        
            #VALIDACIÓN EMAIL
            //echo "El DNI no existe";
            $resultado = validarEmail($conn,$email);
            
            if($resultado!=NULL && $resultado->num_rows>0){  
                echo "El email ya existe";
                header("Location: admi_login.html");
                exit();
            

            }
            else{
                //echo "El email no existe";
                if($clave != $confirmarClave){
                    echo "Clave" . $clave;
                    echo "Confirmar clave" . $confirmarClave;
                    echo "Clave es diferente";
                    header("Location: admi_login.html");
                    exit();
                }
                else{
                    $clave != $confirmarClave;
                    echo "Claves iguales";
                    
                    #SE AGREGA EL REGISTRO EN LA BASE DE DATOS 
                    agregarUsuario($conn,$nombre,$apellido,$dni,$email,$telefono,$clave);
                    
                    #SE CIERRA LA CONEXIÓN DE LA BASE DE DATOS
                    cerrarBDConexion($conn);
                    
                    #MOSTRAR MSJ DE REGISTRO CREADO CON ÉXITO Y REDIRIGE
                    echo "Registro agregado con éxito";
                    header("Location: admi_login.html");
                    exit();
                }
                }
            }

}

main();


?>