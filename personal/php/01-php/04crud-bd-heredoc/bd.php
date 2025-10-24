
<?php

    // Crear conexión con la base de datos.
    // https://www.w3schools.com/php/php_ref_mysqli.asp
    // https://www.php.net/manual/es/class.mysqli-sql-exception.php

function conectarBD(){  /**Conectar la base de datos */ 
    /* Datos para conectar a la base de datos.*/
    $nombreServidor = "localhost";
    $nombreUsuario = "root";
    $passwordBaseDeDatos = "";
    $nombreBaseDeDatos = "crud1";

    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $conn = new mysqli($nombreServidor, $nombreUsuario, $passwordBaseDeDatos, $nombreBaseDeDatos);      
    } catch (Exception $e) {
        //echo 'ERROR:'.$e->getMessage();
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['error'] = TRUE;

        $conn=NULL;
    }   
    return $conn;
}

function cerrarBD($conn){/**Cerrar la conección la base de datos */ 
    //DESCONECTAR
    if ($conn!=NULL){
        $conn->close();
    }    
}


function consultarMiembros($busqueda){ // CONSULTA - SELECT
    $db = conectarBD();
    if ($busqueda==""){
        $sql = 'SELECT * FROM members';
    }else{ // Entró a la pagina por search
           // concatenar en filtro todos los campos por el cual se quiere hacer la busqueda
        $filtro = "firstname like '%{$busqueda}%'";
        $filtro = $filtro . " or lastname like '%{$busqueda}%'";
        $filtro = $filtro . " or lastname like '%{$busqueda}%'";	
        $sql = "SELECT * FROM members where ".$filtro;
    }
    try{
        $result = $db->query($sql);        
    }
    catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['error'] = TRUE;
    } 
    finally{
        cerrarBD($db);
    }
    return $result;
}

function actualizarMiembros($id,$firstname,$lastname,$address){ // ACTUALIZAR - UPDATE
    $db = conectarBD();
        try{
			$sql = "UPDATE members SET firstname = '$firstname', lastname = '$lastname', address = '$address' WHERE id = '$id'";						
			if ( $db->query($sql) ) {
				$_SESSION['message']  = 'Registro actualizado correctamente';
				unset($_SESSION['error']);
			}else{
				$_SESSION['message']  = 'ERROR: No se pudo actualizar -> ('.$db->error.')';	
				$_SESSION['error'] = TRUE;
			}
		}
		catch (Exception $e) {
			$_SESSION['message'] = $e->getMessage();
			$_SESSION['error'] = TRUE;			
		}  
        finally{
            cerrarBD($db);
        }
}

function eliminarMiembro($id){ //ELIMINAR - DELETE
    $db = conectarBD();
        try{
			$sql = "DELETE FROM members WHERE id = {$id}";						
			if ( $db->query($sql) ) {
				$_SESSION['message']  = 'Registro eliminado correctamente';
				unset($_SESSION['error']);
			}else{
				$_SESSION['message']  = 'ERROR: No se pudo eliminar -> ('.$db->error.')';	
				$_SESSION['error'] = TRUE;
			}
		}
		catch (Exception $e) {
			$_SESSION['message'] = $e->getMessage();
			$_SESSION['error'] = TRUE;			
		}  
        finally{
            cerrarBD($db);
        }

}

function agregarMiembro($firstname,$lastname,$address){ // AGEGAR - INSERT
    $db = conectarBD();
    try{
        // hacer uso de una declaración preparada para evitar la inyección de sql    
        $stmt = $db->prepare("INSERT INTO members (firstname, lastname, address) VALUES (?,?,?)");            
        $stmt->bind_param("sss", $firstname, $lastname,$address);

        if ( $stmt->execute() ) {
            $_SESSION['message']  = 'Registro agregado correctamente';
            unset($_SESSION['error']);
        }else{
            $_SESSION['message']  = 'ERROR: No se pudo agregar -> ('.$db->error.')';	
            $_SESSION['error'] = TRUE;
        }    
    }
    catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['error'] = TRUE;        
    } 
    finally{
        cerrarBD($db);
    }

}


  


  ?>
