<?php  

function ejemploImprimirCadenas(){
   print ( "<a href = 'https://www.php.net/manual/es/language.types.string.php'>Cadenas de caracteres (Strings)</a> <br>");
 
   /* STRING */
      
       $largo = strlen("Hello world!");
      //$largo=10;
      print ( "<span style='font-weight: bold;'> Largo de la Cadena</span><br>");
      print("La cadena 'Hello world!' tiene un largo de: ".$largo."<br/><br/>");
      echo "strlen(\"Hello world!\")  = > ",strlen("Hello world!"),"\n<br/>";
      print ( "<span style='font-weight: bold;'> Contar palabras en Cadena</span><br>");
      echo "str_word_count(\"Hello world!\") = > ",str_word_count("Hello world!"),"\n<br/>"; // outputs 2
      print ( "<span style='font-weight: bold;'> Invertir Cadena</span><br>");
      echo "strrev(\"Hello world!\") = > ",strrev("Hello world!"),"\n<br/>"; // outputs !dlrow olleH
      print ( "<span style='font-weight: bold;'> Posicion de una cadena dentro de otra Cadena</span><br>");
      echo "strpos(\"Hello world!\", \"world\") = > ",strpos("Hello world!", "world"),"\n<br/>"; // outputs 6  
      echo("<br/>"); 
      print ( "<span style='font-weight: bold;'> Busca y reemplaza Cadena</span><br>");   
      $result = str_replace("world", "Dolly", "Hello world!");
      echo "str_replace(\"world\", \"Dolly\", \"Hello world!\") = > ",$result,"\n<br/>" ; // outputs Hello 
      echo("<br/>");
   
      //= = = = H E R E D O C = = = =
      print ( "<span style='font-weight: bold;'> = = = = H E R E D O C = = = =</span><br>");   
      print ( "<a href = ' https://www.php.net/manual/es/language.types.string.php#language.types.string.syntax.heredoc'>HEREDOC</a> <br>");
    
      echo("<br/><br/>");
}

function ejemploHeredoc01(){
   $str = <<<PRUEBA
   Ejemplo de una cadena
   expandida en varias líneas
   empleando la sintaxis heredoc.<br/>
PRUEBA;
echo($str);
}

function ejemploHeredoc02(){
   $nombre  = 'MARIANO';
   $acción  = 'Enseñanado PHP';
   $quienes = 'alumnos';
   $str2 = <<<PRUEBA
      <br/>Mi nombre es {$nombre}. 
      Estoy {$acción} .....
      a los {$quienes} ...
      listo !!<br/>
PRUEBA;
   echo($str2);
}

function obtenerDNI($nombre3 ){
   $dni=9999;
   if ($nombre3 == "MARIANO"){
      $dni=1234;
   }
   else if($nombre3 =="DIEGO"){
      $dni=5678;
   }
   return $dni;
}
function obtenerEdad($dni){
   $edad=-1;
   if ($dni==1234){
      $edad=22;
   }
   else if ($dni==5678){
      $edad=43;
   }
   return $edad;
}

function accion(){
   return "Enseñando a programar en PHP";
}
function ejemploHeredoc03(){
   $nombre3 = 'MARIANO';
   $obtenerDNI = 'obtenerDNI';         // FUNCIONES
   $obtenerEdad = obtenerEdad(1234);  // FUNCIONES
   $accion='accion';                   // FUNCIONES
   
   $pagina =  <<<PRUEBA3
   <br/>Mi nombre es {$nombre3}. <br/>
   Mi edad es: {$obtenerEdad }.<br/>
   Mi dni es {$obtenerDNI($nombre3)}.<br/>
   Estoy haciendo ...{$accion()}..
   blabla ...
   listo !!<br/>
PRUEBA3;
   echo($pagina);

}


function main(){
   //ejemploImprimirCadenas();
   //ejemploHeredoc01();
   //ejemploHeredoc02();
   ejemploHeredoc03();
}
main();
?>

