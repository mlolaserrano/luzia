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
        $sql = sprintf($formato, $email, $password);      // rearma con formato
        // Ejecución la consulta SQL.
        //echo($sql);die();
        $resultado = $conn->query($sql);
    }
    return $resultado;
  }

?>