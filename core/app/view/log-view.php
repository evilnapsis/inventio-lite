<div class="row">
	<div class="col-md-12">
		<h1>Bitacora</h1>
<div class="card">
	<div class="card-header">
		BITACORA
	</div>
		<div class="card-body">
		<?php
		// Obtener todos los registro de la bitacora
		$logs = BitacoraData::getAll();
		if(count($logs)>0): ?>

			<table class="table table-bordered table-hover">
			<thead>
			<th>Descripcion</th>
			<th>Usuario</th>
			<th>Modulo  / Accion</th>
			<th>Fecha</th>
			</thead>
			<?php
			foreach($logs as $log):
				$user = UserData::getById($log->user_id); // Obtener los datos del usuario
				?>
				<tr>
				<td><?php echo $log->description; // mostrar descripcion  ?></td>
				<td><?php echo $user->name." ".$user->lastname; // mostrar el nombre del usuario ?></td>
				<td><?php echo $log->module." / ".$log->action; // mostrar el modulo y la accion ?></td>
				<td><?php echo $log->created_at; // Mostrar la fecha de creacion ?></td>
				</tr>
				<?php
			endforeach; ?>
</table>
<?php else:?>
			echo "<p class='alert alert-danger'>No hay Registros en la bitacora</p>";
<?php endif; ?>
		</div>
</div>
	</div>
</div>