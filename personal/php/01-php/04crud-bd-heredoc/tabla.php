<?php

include_once('bd.php');
include_once('edit_delete_modal.php');

function obtenerTabla($busqueda){
    $resultSql = consultarMiembros($busqueda);
    
    $editDelModal='editDelModal';
    $datos="";
    foreach ($resultSql as $row) {
        $fila=<<<FIL
            <tr>
                <td>{$row['id']}</td>
                <td>{$row['firstname']}</td>
                <td>{$row['lastname']}</td>
                <td>{$row['address']}</td>
                <td>
                    <a href="#edit_{$row['id']}" class="btn btn-success btn-sm" data-toggle="modal"><span class="fa fa-edit"></span> Editar</a>
                    <a href="#delete_{$row['id']}" class="btn btn-danger btn-sm" data-toggle="modal"><span class="fa fa-trash"></span> Eliminar</a>
                </td>
                {$editDelModal($row)}                
            </tr>
            
        FIL;
        $datos=$datos.$fila;
    }

    $mitabla=<<<TABLA
        <table class="table table-bordered table-striped" style="margin-top:20px;">
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Dirección</th>
                <th>Acción</th>
            </thead>
            <tbody>
                {$datos}
            </tbody>
            </table>
            
    TABLA;
    
    return $mitabla;
}
  
?>
