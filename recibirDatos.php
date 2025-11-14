<?php
function recibirDatos(){

	//Recibe los datos por 'post' o por 'get'
	$dni="";
    $nombre="";
	$apellido="";
	$email="";
	$telefono="";
	$contrasena="";
	
    if (isset($_REQUEST['dni'])){
		$dni=$_REQUEST['dni'];
	}
    
	if (isset($_REQUEST['nombre'])){
		$nombre=$_REQUEST['nombre'];
	}	
	if (isset($_REQUEST['apellido'])){
		$apellido=$_REQUEST['apellido'];
	}
	if (isset($_REQUEST['email'])){
		$email=$_REQUEST['email'];
	}	
	if (isset($_REQUEST['telefono'])){
		$telefono=$_REQUEST['telefono'];
	}	
	if (isset($_REQUEST['contrasena'])){
		$contrasena=$_REQUEST['contrasena'];
	}
	if (isset($_REQUEST['pass'])){
		$pass=$_REQUEST['pass'];
	}


	// * * * * * * * * * * * * * * * * * 
    // Contruyo la pagina de respuesta en un variable heredoc
	//   y le agrego los valores de las variables que fueron recibidas
	//   por el formulario.
	$paginaRespuesta=<<<TXT
	<h2>DATOS RECIBIDOS</h2>
	<label>DNI: </label ><b style='color:red'>
		{$dni}
		</b></br>
	<label>Nombre: </label ><b style='color:red'>
		{$nombre}
		</b></br>
	<label>Apellido: </label><b style='color:red'>
		{$apellido}
		</b></br>
	<label>Email: </label><b style='color:red'>
		{$email}
	</b></br>
	<label>Teléfono: </label><b style='color:red'>
		{$telefono}
	</b></br>
	<label>Contraseña: </label><b style='color:red'>
		{$contrasena}
	</b></br>
	<hr> 
TXT;
return $paginaRespuesta;     //Retorno la pagina de respuesta

}

function main(){
	echo recibirDatos();
}
main();

?>