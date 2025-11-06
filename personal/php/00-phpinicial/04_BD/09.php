<?php
    include 'BD.php';  // importar el módulo 

    function crearConsulta(){
        //$sql = "select * from pais where id in (3,4,5,6)"; 

        //Armado de una consulta
        $listaCodigo = "(3,4,5,6,7)";                                // lista de códigos
        $tabla = "pais";                                             // tabla de la base de datos
        $sql   = "select * from $tabla where id in $listaCodigo ;";  // consulta sql       

        return $sql; // retorna la consulta
    }

    function imprimirConsulta($result){
        //print(var_dump ($result));           // descomentar por si quiero debuguear
        //die();                               // descomentar por si quiero debuguear
        $fila=$result->fetch_assoc();
        while ($fila  ) {             // http://php.net/manual/es/mysqli-result.fetch-assoc.php
            echo ( $fila["id"].",". $fila["nombre"]."</br>");
            $fila=$result->fetch_assoc();
        } 
    }

    function main(){
        $conn   = conectarBD();              // conecta a la base de datos
        $sql    = crearConsulta();           // carga el texto con la consulta sql
        $result = ejecutarSQL($conn, $sql ); // ejecuta la consulta sql
        imprimirConsulta($result);           // imprime el resultado de la consulta
        cerrarBDConexion($conn);             // desconecta la base de datos
    }

    main();

?>




