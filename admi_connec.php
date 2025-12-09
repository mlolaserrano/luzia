<?php
    // Datos para conectar a la base de datos.
    const nombreServidor    = "localhost";
    const nombreUsuario     = "root";
    const claveBaseDeDatos  = "";
    const nombreBaseDeDatos = "luzia";        

    function conectarBDLuzia(){  
      //echo "Entrar a BD Luzia"; (PRUEBA)

        mysqli_report(MYSQLI_REPORT_STRICT);         //para que lance excepciones
        try {                      // Crear conexión con la base de datos.
            $conn = new mysqli(nombreServidor, nombreUsuario, claveBaseDeDatos, nombreBaseDeDatos);      
        } catch (Exception $e) {   // si hay un error
            
            // $_SESSION['message'] = $e->getMessage(); //guarda el mensaje de error en la variable de sesion
            // $_SESSION['error'] = TRUE;               //guarda un TRUE en la variable de sesion
            echo 'ERROR:'.$e->getMessage();
            $conn=NULL;                              //devuelve NULL
        }   
        return $conn;
      
       
      }


  function cerrarBDConexion($conn){
    if ($conn!=NULL){
        $conn->close();
    }    
  }


  // se consulta en la tabla de usuario de la BD luzia
    
      
  //function consultarUsuario($conn,$dni,$nombre,$apellido,$email,$telefono,$clave){
   function consultarUsuario($conn, $email, $clave){
    $resultado = NULL;
    
    // Traer todas las columnas necesarias
    $sql = "SELECT id, dni, nombre, apellido, email, telefono 
            FROM usuario 
            WHERE email = '$email' AND clave = '$clave'";

    $resultado = $conn->query($sql);
    
    return $resultado;
}


  function validarDni($conn,$dni){
    $resultado = NULL;
    $sql="SELECT * FROM usuario 
          WHERE dni=$dni";  
    $resultado = $conn->query($sql);                   
    return $resultado;
  }


  function validarEmail($conn,$email){
    $resultado = NULL;
    $sql="SELECT * FROM usuario  
          WHERE email='$email'";  
    $resultado = $conn->query($sql);                   
    return $resultado;
  }

  

  function agregarUsuario($conn,$nombre,$apellido,$dni,$email,$telefono,$clave){
    $filasAfectadas = 0;
    $sql="INSERT INTO usuario (nombre,apellido,dni,email,telefono,clave,rol) 
          VALUES ('$nombre','$apellido',$dni,'$email',$telefono,'$clave','admin')";
    $conn->query($sql);
    $filasAfectadas=$conn->affected_rows;
    return $filasAfectadas;
  }




?>