<?php
    // https://www.w3schools.com/php/php_ref_mysqli.asp
    // Crear conexión con la base de datos.
    // https://www.w3schools.com/php/php_ref_mysqli.asp
    // https://www.php.net/manual/es/class.mysqli-sql-exception.php

    // Datos para conectar a la base de datos.
    const nombreServidor = "localhost";
    const nombreUsuario = "root";
    const passwordBaseDeDatos = "";
    const nombreBaseDeDatos = "ubicacion";        

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


function ejecutarSQL($conn, $sql) {  
    //realiza una consutla y retorna el resultado

    // realiza una consulta sql $sql a un coneccion $conn  
    $result = $conn->query($sql);

    // retornar el resultado
    return $result;
}

function cerrarBDConexion($conn){
    if ($conn!=NULL){
        $conn->close();
    }    
  }

?>




