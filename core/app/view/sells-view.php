<div class="row">
	<div class="col-md-12">
		<h1><i class='glyphicon glyphicon-shopping-cart'></i> Lista de Ventas</h1>
		<div class="clearfix"></div>


<div class="card">
	<div class="card-header">
		VENTAS
	</div>
		<div class="card-body p-0">

<?php

$products = SellData::getSells();

if(count($products)>0){

	?>

<div class="table-responsive">
<table class="table table-bordered table-hover table-sm mb-0">
	<thead>
		<th></th>
		<th>Productos</th>
		<th>Total</th>
		<th>Fecha</th>
		<th></th>
	</thead>
	<tbody>
	<?php foreach($products as $sell):?>

	<tr>
		<td style="width:60px;">
		<a href="index.php?view=onesell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-link" title="Ver Detalle"><i class="bi bi-eye"></i></a>
		<a href="report/ticket.php?id=<?php echo $sell->id; ?>" target="_blank" class="btn btn-xs btn-link" title="Imprimir Ticket"><i class="bi bi-receipt"></i></a></td>

		<td>

<?php
$operations = OperationData::getAllProductsBySellId($sell->id);
echo count($operations);
?>
		</td>
		<td>

<?php
$total= $sell->total-$sell->discount;
		echo "<b>$ ".number_format($total)."</b>";

?>			

		</td>
		<td><?php echo $sell->created_at; ?></td>
		<td style="width:30px;"><a href="index.php?view=delsell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-danger"><i class="bi bi-trash"></i></a></td>
	</tr>

<?php endforeach; ?>
	</tbody>
</table>
</div>

<div class="clearfix"></div>

	<?php
}else{
	?>
	<div class="jumbotron">
		<h2>No hay ventas</h2>
		<p>No se ha realizado ninguna venta.</p>
	</div>
	<?php
}

?>
		</div>
</div>


<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
