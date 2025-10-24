<?php

	session_start();
	include_once('bd.php');
						

	if(isset($_GET['id'])){
		eliminarMiembro($_GET['id']);

	}
	else{
		$_SESSION['message'] = 'Seleccione registro para eliminar';
		$_SESSION['error'] = TRUE;	
	}

	header('location: page_crud.php?id=delete');

?>