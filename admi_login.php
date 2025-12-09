<?php
session_start();

include "admi_connec.php";
include "admi_sesion.php";  

function main(){
    $email = $_POST['email'];      
    $clave = $_POST['clave'];

    $conn = conectarBDLuzia(); // conectar a base de datos
    $resultado = consultarUsuario($conn,$email,$clave); // Consulta usuario en la base de datos 

    if($resultado != NULL && $resultado->num_rows > 0){  
        $row = mysqli_fetch_assoc($resultado); 
        if ($row) {
            // Guardar datos en sesión
            $_SESSION['id']       = $row['id'];
            $_SESSION['nombre']   = $row['nombre'];
            $_SESSION['apellido'] = $row['apellido'];
            $_SESSION['email']    = $row['email'];
            $_SESSION['dni']      = $row['dni'];
            $_SESSION['telefono'] = $row['telefono'];

            mysqli_free_result($resultado);
            cerrarBDConexion($conn);

            // Redirigir al index
            header("Location: admi_productos.php");
            exit();
        } else {
            echo "Usuario no encontrado";
        }
    } else {
        echo 'El email o clave es incorrecto, <a href="login.html">vuelva a intentarlo</a>.<br/>';
    }
}

main();

?>