<?php

include_once('bd.php');

function obtenerTabla($busqueda){
    $resultSql = consultarMiembros($busqueda);

?>
    <table class="table table-bordered table-striped" style="margin-top:20px;">
    <thead>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Dirección</th>
        <th>Acción</th>
    </thead>
    <tbody>
        <?php
                    
            foreach ($resultSql as $row) {
        ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td>
                        <a href="#edit_<?php echo $row['id']; ?>" class="btn btn-success btn-sm" data-toggle="modal"><span class="fa fa-edit"></span> Editar</a>
                        <a href="#delete_<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" data-toggle="modal"><span class="fa fa-trash"></span> Eliminar</a>
                    </td>
                    <?php include('edit_delete_modal.php'); ?>
                </tr>
        <?php
            }
        ?>
            
    </tbody>
    </table>
<?php
}
?>
