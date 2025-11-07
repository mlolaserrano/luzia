
<?php
function editDelModal($row){

	$modal =<<<MOD
	<!-- Editar -->
		<div class="modal fade" id="edit_{$row['id']}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Editar registro</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
					<div class="container-fluid">
					<form method="POST" action="edit.php?id={$row['id']}">
						<div class="row form-group">
							<div class="col-sm-2">
								<label class="control-label" style="position:relative; top:7px;">Nombre:</label>
							</div>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="firstname" value="{$row['firstname']}">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2">
								<label class="control-label" style="position:relative; top:7px;">Apellido:</label>
							</div>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="lastname" value="{$row['lastname']}">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2">
								<label class="control-label" style="position:relative; top:7px;">Dirección:</label>
							</div>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="address" value="{$row['address']}">
							</div>
						</div>
					</div> 
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cancelar</button>
						<button type="submit" name="edit" class="btn btn-success"><span class="fa fa-check"></span> Actualizar</a>
					</form>
					</div>

				</div>
			</div>
		</div>

		<!-- Eliminar -->
		<div class="modal fade" id="delete_{$row['id']}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Borrar registro</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">	
						<p class="text-center">¿Estas seguro en borrar los datos de?</p>
						<h2 class="text-center">{$row['firstname']} {$row['lastname']}</h2>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cancelar</button>
						<a href="delete.php?id={$row['id']}" class="btn btn-danger"><span class="fa fa-trash"></span> Si</a>
					</div>

				</div>
			</div>
		</div>
	MOD;
	return $modal;
}
?>

