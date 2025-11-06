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
	<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
  		<a class="navbar-brand" href="http://localhost/" target="_blank">localhost</a>
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>

	  	<div class="collapse navbar-collapse" id="navbarColor02">
		    <ul class="navbar-nav mr-auto">
		      	<li class="nav-item">
		        <a class="nav-link" href="http://uca.edu.ar/es" target="_blank">UCA</a>
		      	</li>
		      	<li class="nav-item dropdown">
	              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download" aria-expanded="false">Redes Sociales <span class="caret"></span></a>
	              <div class="dropdown-menu" aria-labelledby="download">
	                <a class="dropdown-item" href="https://www.facebook.com/universidad.catolica.argentina/" target="_blank">facebook</a>
	                <div class="dropdown-divider"></div>
	                <a class="dropdown-item" href="https://www.youtube.com/user/UCAarg" target="_blank">youtube</a>
	 
	              </div>
	            </li>
		      	<li class="nav-item">
		        <a class="nav-link" href="https://www.facebook.com/universidad.catolica.argentina/"  target="_blank"><i class="fa fa-facebook-official"></i> Like</a>
		      	</li>
		      	<li class="nav-item">
		        <a class="nav-link text-warning" href="https://www.google.com/" target="_blank"><i class="fa fa-code"></i> Google</a>
		    </ul>
		    <form action="page_crud.php" method="get" class="form-inline my-2 my-lg-0">
		      <input  class="form-control mr-sm-2" placeholder="Buscar" type="text" name="search">
		      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Buscar</button>
		    </form>
	  	</div>
	</nav>
	<h1 class="page-header text-center">PHP CRUD</h1>
	<div class="row">
		<div class="col-sm-12">
			<a href="#addnew" class="btn btn-primary" data-toggle="modal"><span class="fa fa-plus"></span> Nuevo</a>
            <?php 
                session_start();
                if(isset($_SESSION['message'])){
					$tipoAlert="alert-success";					
					if(isset($_SESSION['error'])){
						$tipoAlert="alert-danger";
					}

                    ?>
					<div class="alert alert-dismissible <?php echo $tipoAlert ?>" role="alert style="margin-top:20px;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php

                    unset($_SESSION['message']);
					unset($_SESSION['error']);
                }

				include('tabla.php');
				$busqueda="";
				if (isset($_GET['search'])){
					$busqueda=$_GET['search'];
				} 	
				obtenerTabla($busqueda)
            ?>
			
		</div>
	</div>
</div>
<?php include('add_modal.php'); ?>

</body>
</html>
