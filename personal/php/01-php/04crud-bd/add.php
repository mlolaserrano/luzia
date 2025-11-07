<?php

	session_start();
	include_once('bd.php');

	if(isset($_POST['add'])){
		$fn=$_POST['firstname'];
		$ln=$_POST['lastname'];
		$ad=$_POST['address'];

		agregarMiembro($fn,$ln,$ad);	

	}else{
		$_SESSION['message'] = 'Debe completar el formulario para agregar registro';
		$_SESSION['error'] = TRUE;
	}

	header('location: page_crud.php?id=new');
	
?>
