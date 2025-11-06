<?php
include('tabla.php');                    // Incluye el archivo que contiene la función obtenerTabla
include('menu.php');                     // Incluye el archivo que contiene la función obtenerMenu
include('add_modal.php');                // Incluye el archivo que contiene la función page_add

function main_page_crud(){               // Define la función principal para la página CRUD
	
	$menu=obtenerMenu();                 // Obtiene el menú HTML
	$addModal=page_add();                // Obtiene el modal para añadir nuevos registros
	$tipoAlert="";                       // Inicializa la variable para el tipo de alerta
	$mensaje_error="";                   // Inicializa la variable para el mensaje de error
	$busqueda="";                        // Inicializa la variable para la búsqueda
	$obtenerTabla="";                    // Inicializa la variable para la función obtenerTabla
	$mensajes_de_errores="";             // Inicializa la variable para los mensajes de error
	$obtenerTabla="obtenerTabla";        // Asigna la función obtenerTabla a la variable

	// Si viene una búsqueda
	if (isset($_GET['search'])){         // Verifica si hay una búsqueda en la URL
	$busqueda=$_GET['search'];           // Asigna el valor de la búsqueda a la variable
	} 	
	
	// INICIO->MENSAJES_X_SESION: Manejo de los mensajes a través de la session. 
	session_start();                     // Inicia la sesión
	if(isset($_SESSION['message'])){     // Verifica si hay un mensaje en la sesión
		$tipoAlert="alert-success";      // Asigna el tipo de alerta como éxito
		if(isset($_SESSION['error'])){   // Verifica si hay un error en la sesión
			$tipoAlert="alert-danger";   // Asigna el tipo de alerta como error
		}
		$mensaje_error=$_SESSION['message']; // Asigna el mensaje de la sesión a la variable
		$mensajes_de_errores=<<<ERR
			<div id="9999" class="alert alert-dismissible  {$tipoAlert} " role="alert style="margin-top:20px; ">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				{$mensaje_error}
			</div>
		ERR;                             // Crea el HTML para mostrar el mensaje de error
		unset($_SESSION['message']);     // Elimina el mensaje de la sesión una vez escrito en HTML
		unset($_SESSION['error']);       // Elimina el error de la sesión
	}
	// FIN->MENSAJES_X_SESION
	
	$pagina_crud=<<<PAGINA
	<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>PHP CRUD</title>
		<!--	-->
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>	
		<link rel="stylesheet" type="text/css" href="assets/css/custom.css">
		
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

	</head>
	<body>
		<div class="container">
				{$menu}

			<h1 class="page-header text-center">PHP CRUD</h1>
			<div class="row">
				<div class="col-sm-12">

					<a href="#addnew" class="btn btn-primary" data-toggle="modal"><span class="fa fa-plus"></span> Nuevo</a>

					{$mensajes_de_errores}

					{$obtenerTabla($busqueda)}
					
				</div>
			</div>
		</div>
			{$addModal}
		</body>
		</html>	 
	PAGINA;

	echo $pagina_crud;
}
main_page_crud();

 




