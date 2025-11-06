<?php
include 'BD.php';  // importar el módulo 

function main(){
    $conn   = conectarBD();              // conecta a la base de datos
    
    $sql = "SELECT * FROM pais";         // sql crear la consulta
  
    $result = ejecutarSQL($conn, $sql ); // ejecuta la consulta sql
    
    // Armar una tabla html con los datos del resultado de la consulta
    $tabla="";
    if ($result->num_rows > 0) {         // Si cantidad de filas es mayor a cero
    	$tabla = $tabla .  "<table>";		
        $row = $result->fetch_assoc();
        while($row!=NULL) {              // mientras haya filas	
            $tabla = $tabla . "<tr><td>".$row["id"]."</td><td>".$row["nombre"]."</td></tr>";
            $row = $result->fetch_assoc();
        }        
    } 
    else {  
        $tabla = "0 results";
    }
    
    echo $tabla;                         // imprime la tabla
    cerrarBDConexion($conn);             // desconecta la base de datos 
}   
main();


?>



<!--
    // COMENTARIOS ...
    die();
    echo("<br/>");
    echo($result->num_rows);           // cantidad de filas que trae la consulta
    echo("<br/>");

    echo("<br/>");
    var_dump ($result);                // imprime el objeto "Como cuando hacemos un print e un Dict en python"
    echo("<br/>");

    var_dump ($result->fetch_assoc());
    echo("<br/>");
    var_dump ($result->fetch_assoc());
    

-->