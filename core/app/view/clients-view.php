<div class="row">
	<div class="col-md-12">

		<h1>Directorio de Clientes</h1>
<div class="mb-3">
	<a href="index.php?view=newclient" class="btn btn-primary"><i class='fa fa-smile-o'></i> Nuevo Cliente</a>
  <a href="report/clients-pdf.php" target="_blank" class="btn btn-success text-white"><i class="fa fa-download"></i> Descargar PDF</a>
</div>	
<br>
<div class="card">
	<div class="card-header">
		CLIENTES
	</div>
		<div class="card-body">


		<?php

		$users = PersonData::getClients();
		if(count($users)>0){
			// si hay usuarios
			?>

			<div class="table-responsive">
			<table class="table table-bordered table-hover">
			<thead>
			<th>Nombre completo</th>
			<th>Direccion</th>
			<th>Email</th>
			<th>Telefono</th>
			<th></th>
			</thead>
      <tbody>
			<?php
			foreach($users as $user){
				?>
				<tr>
				<td><?php echo $user->name." ".$user->lastname; ?></td>
				<td><?php echo $user->address1; ?></td>
				<td><?php echo $user->email1; ?></td>
				<td><?php echo $user->phone1; ?></td>
				<td style="width:130px;">
				<a href="index.php?view=editclient&id=<?php echo $user->id;?>" class="btn btn-warning btn-xs">Editar</a>
				<a href="index.php?view=delclient&id=<?php echo $user->id;?>" class="btn btn-danger btn-xs">Eliminar</a>
				</td>
				</tr>
				<?php

			}
      ?>
      </tbody>
			</table>
			</div>


		<?php


		}else{
			echo "<p class='alert alert-danger'>No hay clientes</p>";
		}


		?>
		</div>
</div>


	</div>
</div>
