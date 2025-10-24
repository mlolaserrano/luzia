<?php 
function pagina(){
   $pagina=<<<PAG
   <html>
      <body>
       
         <form action = "06.php" method = "get">
            Name: <input type = "text" name = "nombre" />
            Age: <input type = "text" name = "edad" />
            <input type = "submit" />
         </form>
         
      </body>
   </html>
PAG;
echo $pagina;
}

function recibirDatos(){
   if(isset($_REQUEST["nombre"]) && isset($_REQUEST["edad"])) {
      echo "Nombre: ". $_REQUEST["nombre"]. "<br />";
      echo "Edad:  ". $_REQUEST["edad"]. " .";     
   }else{
      pagina();
   }
}
function main(){   
   recibirDatos();
   
}
main();
?>




