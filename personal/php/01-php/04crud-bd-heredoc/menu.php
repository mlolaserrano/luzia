<?php

function obtenerMenu(){
    $miMenu=<<<MENU
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
MENU;
    return $miMenu;

}


?>