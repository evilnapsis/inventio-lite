<div class="row">
	<div class="col-md-12">
		<h1><i class='glyphicon glyphicon-shopping-cart'></i> COMPRAS</h1>
		<div class="clearfix"></div>
<div class="card">
	<div class="card-header">
		COMPRAS
	</div>
		<div class="card-body p-0">



<?php
$products = SellData::getRes();

if(count($products)>0){
	?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-sm mb-0">
	<thead>
		<th></th>
		<th>Producto</th>
		<th>Total</th>
		<th>Fecha</th>
		<th></th>
	</thead>
	<?php foreach($products as $sell):?>

	<tr>
		<td style="width:60px;">
			<a href="index.php?view=onere&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-link" title="Ver Detalle"><i class="bi bi-eye"></i></a>
			<a href="report/ticket-re.php?id=<?php echo $sell->id; ?>" target="_blank" class="btn btn-xs btn-link" title="Imprimir Ticket"><i class="bi bi-receipt"></i></a>
		</td>

		<td>

<?php
$operations = OperationData::getAllProductsBySellId($sell->id);
echo count($operations);
?>
		</td>
		<td>

<?php
$total=0;
	foreach($operations as $operation){
		$product  = $operation->getProduct();
		$total += $operation->q*$product->price_in;
	}
		echo "<b>$ ".number_format($total)."</b>";

?>			

		</td>
		<td><?php echo $sell->created_at; ?></td>
		<td style="width:30px;"><a href="index.php?view=delre&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-danger"><i class="bi bi-trash"></i></a></td>
	</tr>

<?php endforeach; ?>

</table>
</div>


	<?php
}else{
	?>
	<div class="jumbotron">
		<h2>No hay datos</h2>
		<p>No se ha realizado ninguna operacion.</p>
	</div>
	<?php
}

?>
		</div>
</div>

	</div>
</div>
