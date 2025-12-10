<?php
    // Datos para conectar a la base de datos.
    const nombreServidor    = "localhost";
    const nombreUsuario     = "root";
    const claveBaseDeDatos  = "";
    const nombreBaseDeDatos = "luzia";        

    function conectarBDLuzia(){  
      //echo "Entrar a BD Luzia"; (PRUEBA)

        mysqli_report(MYSQLI_REPORT_STRICT);  //genera reporte de errores y advertencias en mySQL a través de la const MYSQLI_REPORT_STRICT
        
        try {  // Controlar excepciones cuando se ejecute la línea $conn (conectar a BD)
            
          $conn = new mysqli(nombreServidor, nombreUsuario, claveBaseDeDatos, nombreBaseDeDatos);  // Crear conexión con la base de datos.    
        } 

        catch (Exception $e) {   // si hay un error
            
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
    //echo "Agregar usuario";

    $filasAfectadas = 0;              //limpio variable de trabajo

    $sql = "INSERT INTO usuario (nombre, apellido, dni, email, telefono, clave, rol) 
            VALUES (?, ?, ?, ?, ?, ?, 'admin')";
    
    // 3. Preparar la sentencia
    if ($stmt = $conn->prepare($sql)) {
        
        // 4. Vincular los parámetros y especificar el tipo de dato (i=integer, s=string)
        // Ejemplo: 'sssssis' asumiendo: (nombre-s, apellido-s, dni-s, email-s, telefono-s, clave-s, rol-s)
        // *Nota: Se usa 's' para dni/teléfono para manejar números grandes o ceros iniciales.
        $stmt->bind_param("ssisis", $nombre, $apellido, $dni, $email, $telefono, $clave);
        
        // 5. Ejecutar la sentencia
        $stmt->execute();

        // 6. Obtener las filas afectadas y cerrar la sentencia
        $filasAfectadas = $stmt->affected_rows;
        $stmt->close();

        return $filasAfectadas;

    } else {
        // Manejo de error si la preparación de la consulta falla
        // Puedes agregar un log de errores aquí
        // echo "Error en la preparación: " . $conn->error; 
        return 0;
    }
  }




?>