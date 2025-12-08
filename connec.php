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
    
      
  //función consultarUsuario($conn,$dni,$nombre,$apellido,$email,$telefono,$clave){
   function consultarUsuario($conn, $email, $clave){
    $resultado = NULL;
    
    // Trae todas las columnas necesarias
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
          VALUES ('$nombre','$apellido',$dni,'$email',$telefono,'$clave','cliente')";
    $conn->query($sql);
    $filasAfectadas=$conn->affected_rows;
    return $filasAfectadas;
  }

function actualizarUsuario($conn, $nombre, $apellido, $telefono, $email) {
    $filasAfectadas = 0;

    // Usamos sentencia preparada para evitar SQL Injection 
    // Los valores se envían al servidor de base de datos como parámetros, no como parte del texto SQL.
    $sql = "UPDATE usuario 
            SET nombre = ?, apellido = ?, telefono = ? 
            WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $apellido, $telefono, $email);

    $stmt->execute();
    $filasAfectadas = $stmt->affected_rows;

    $stmt->close();
    return $filasAfectadas;
}

#CONSULTA EN BD SOBRE EL PEDIDO DEL CLIENTE

function pedidoCliente($conn, $id_usuario) {
    $pedidos = NULL;

    // Sentencia preparada para evitar SQL Injection
    $sql = "SELECT id, fecha, estado, total 
            FROM pedido 
            WHERE id_usuario = ? 
            ORDER BY fecha DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $pedidos = $stmt->get_result();

    return $pedidos; // devuelve un mysqli_result con los pedidos
}


function detallePedidoCliente($conn, $id_pedido) {
    $detalle = NULL;

    $sql = "SELECT producto.imagen AS Foto, producto.sku AS Código, producto.nombre AS Producto, 
            pedido.precio AS 'Precio unitario', pedido.total AS Total, pedido.cantidad AS Cantidad  
            FROM pedido
            INNER JOIN producto ON pedido.id_producto = producto.id
            WHERE pedido.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_pedido);
    $stmt->execute();
    $detalle = $stmt->get_result();
    
    // NOTA: No se cierra el $stmt aquí. Es mejor dejar el $detalle (mysqli_result) abierto para iterar.
    
    
    return $detalle; // Devuelve un mysqli_result con los productos de esa orden
}
/*
  
  
  

  function consultaDatosUsuario($conn,$email){
    $resultado = NULL;
          
    $sql="SELECT * FROM usuario WHERE email=$email"; //  
    $res_msqli = $conn->query($sql);                   // respuesta en formato mysqli
    $resultado = $res_msqli->fetch_assoc();            //devuelve un array asociativo
    $res_msqli->free();                                //libera el conjunto de resultados
    
    return $resultado;
  }

  function actualizarUsuario($conn,$dni,$nombre,$apellido,$email,$telefono,$clave){
    $filasAfectadas = 0;
    $sql="UPDATE usuario SET apellido = '$apellido' , nombre = '$nombre' WHERE email= '$email' AND clave='$clave'";
    $conn->query($sql);
    $filasAfectadas=$conn->affected_rows;
    return $filasAfectadas;
  }
    */
?>