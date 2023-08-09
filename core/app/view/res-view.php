<div class="row">
	<div class="col-md-12">
		<h1><i class='glyphicon glyphicon-shopping-cart'></i> COMPRAS</h1>
		<div class="clearfix"></div>
<div class="card">
	<div class="card-header">
		COMPRAS
	</div>
		<div class="card-body">



<?php
$products = SellData::getRes();

if(count($products)>0){
	?>
<table class="table table-bordered table-hover	">
	<thead>
		<th></th>
		<th>Producto</th>
		<th>Total</th>
		<th>Fecha</th>
		<th></th>
	</thead>
	<?php foreach($products as $sell):?>

	<tr>
		<td style="width:30px;"><a href="index.php?view=onere&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-link"><i class="bi bi-eye"></i></a></td>

		<td>

<?php
$operations = OperationData::getAllProductsBySellId($sell->id);
echo count($operations);
?>
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