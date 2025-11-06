<?php
    // https://www.w3schools.com/php/php_ref_mysqli.asp
    // Crear conexión con la base de datos.
    // https://www.w3schools.com/php/php_ref_mysqli.asp
    // https://www.php.net/manual/es/class.mysqli-sql-exception.php

    // Datos para conectar a la base de datos.
    const nombreServidor = "localhost";
    const nombreUsuario = "root";
    const passwordBaseDeDatos = "";
    const nombreBaseDeDatos = "bd_usuario";        

    function conectarBD(){  
        mysqli_report(MYSQLI_REPORT_STRICT);         //para que lance excepciones
        try {                      // Crear conexión con la base de datos.
            $conn = new mysqli(nombreServidor, nombreUsuario, passwordBaseDeDatos, nombreBaseDeDatos);      
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

  function consultarUsuario($conn,$email,$password){
    $resultado = NULL;
    if ($conn!=NULL){
        // Confección del string de la Consulta segura para evitar inyecciones SQL.
        $formato = "SELECT * FROM usuario WHERE email='%s' AND password = '%s'";
        $email=$conn->real_escape_string($email);         //filtra
        $password = $conn->real_escape_string($password); //filtra
        $sql = sprintf($formato, $email, $password);      // rearma con format
        
        ////Consulta sin filtro 
        ////$sql = "SELECT * FROM usuario WHERE email= $email AND password = $password";
    
        $resultado = $conn->query($sql);
    }
    return $resultado;
  }

  function verficarEmail($conn,$email){
    $resultado = NULL;
    if ($conn!=NULL){
        // Confección del string de la Consulta segura para evitar inyecciones SQL.
        $formato = "SELECT * FROM usuario WHERE email='%s'";
        $email=$conn->real_escape_string($email);         //filtra
        $sql = sprintf($formato, $email);      // rearma con formato
        // Ejecución la consulta SQL.
        $resultado = $conn->query($sql);
    }
    return $resultado;
  }

  function agregarUsuario($conn,$apellido,$nombre,$email,$password){
    $filasAfectadas = 0;
    if ($conn!=NULL){     
      /* crear una sentencia preparada */
      if ($stmt = $conn->prepare("INSERT INTO usuario (email,password,apellido,nombre) VALUES (?,?,?,?)")) {
        /* ligar parámetros para marcadores */
        $stmt->bind_param('ssss',$email,$password,$apellido,$nombre);
        /* ejecutar la consulta */
        $stmt->execute();
        /* obtener la cantidad de filas afectadas en la inserción */
        $filasAfectadas=$stmt->affected_rows;
        /* cerrar sentencia */
        $stmt->close();
      }
    }
    return $filasAfectadas;
  }

  function consultaDatosUsuario($conn,$email){
    $resultado = NULL;
    if ($conn!=NULL){
      $sql="SELECT * FROM usuario WHERE email={$email}";
        // Confección del string de la Consulta segura para evitar inyecciones SQL.
        #$formato = "SELECT * FROM usuario WHERE email='%s'";
        #$email=$conn->real_escape_string($email);         //filtra
        #$sql = sprintf($formato, $email);      // rearma con formato
        // Ejecución la consulta SQL.
        $res_msqli = $conn->query($sql); // respuesta en formato mysqli

        /* obtener un array asociativo */
        $resultado = $res_msqli->fetch_assoc();

        /* liberar el conjunto de resultados */
        $res_msqli->free();

    }
    return $resultado;
  }

  function actualizarUsuario($conn,$email,$password,$apellido,$nombre ){
    $filasAfectadas = 0;
    if ($conn!=NULL){     
      /* crear una sentencia preparada */
      if ($stmt = $conn->prepare("UPDATE usuario SET apellido = ? , nombre = ? WHERE email= ? AND password=?")) {
        /* ligar parámetros para marcadores */
        $stmt->bind_param('ssss',$apellido,$nombre,$email,$password);
        /* ejecutar la consulta */
        $stmt->execute();
        /* obtener la cantidad de filas afectadas en la inserción */
        $filasAfectadas=$stmt->affected_rows;
        /* cerrar sentencia */
        $stmt->close();
      }
    }
    return $filasAfectadas;

  }
?>