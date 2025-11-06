<?php

	session_start();
	include_once('bd.php');

	if(isset($_POST['edit'])){
		
		$id = $_REQUEST['id'];
		$fn = $_REQUEST['firstname'];
		$ln = $_REQUEST['lastname'];
		$ad = $_REQUEST['address'];
		actualizarMiembros($id,$fn,$ln,$ad);

	}
	else{
		$_SESSION['message'] = 'Primero debe llenar el form';
		$_SESSION['error'] = TRUE;
	}

	header('location: page_crud.php?id=edit');

?>