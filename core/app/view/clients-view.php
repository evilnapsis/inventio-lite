<div class="row">
	<div class="col-md-12">

		<h1>Directorio de Clientes</h1>
	<div class="">
	<a href="index.php?view=newclient" class="btn btn-secondary"><i class='fa fa-smile-o'></i> Nuevo Cliente</a>
<div class="btn-group pull-right">
  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/clients-word.php">Word 2007 (.docx)</a></li>
  </ul>
</div>
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

			<table class="table table-bordered table-hover">
			<thead>
			<th>Nombre completo</th>
			<th>Direccion</th>
			<th>Email</th>
			<th>Telefono</th>
			<th></th>
			</thead>
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
echo "</table>";


		}else{
			echo "<p class='alert alert-danger'>No hay clientes</p>";
		}


		?>
		</div>
</div>


	</div>
</div>