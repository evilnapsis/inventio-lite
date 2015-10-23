<div class="row">
	<div class="col-md-12">
<div class="btn-group pull-right">
<a href="./index.php?view=boxhistory" class="btn btn-primary "><i class="fa fa-clock-o"></i> Historial</a>
<a href="./index.php?view=processbox" class="btn btn-primary ">Procesar Ventas <i class="fa fa-arrow-right"></i></a>
</div>
		<h1><i class='fa fa-archive'></i> Caja</h1>
		<div class="clearfix"></div>


<?php
$products = SellData::getSellsUnBoxed();
if(count($products)>0){
$total_total = 0;
?>
<br>
<table class="table table-bordered table-hover	">
	<thead>
		<th></th>
		<th>Producto</th>
		<th>Total</th>
		<th>Fecha</th>
	</thead>
	<?php foreach($products as $sell):?>

	<tr>
		<td style="width:30px;">

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
		$total += $operation->q*$product->price_out;
	}
		$total_total += $total;
		echo "<b>$ ".number_format($total,2,".",",")."</b>";

?>			

		</td>
		<td><?php echo $sell->created_at; ?></td>
	</tr>

<?php endforeach; ?>

</table>
<h1>Total: <?php echo "$ ".number_format($total_total,2,".",","); ?></h1>
	<?php
}else {

?>
	<div class="jumbotron">
		<h2>No hay ventas</h2>
		<p>No se ha realizado ninguna venta.</p>
	</div>

<?php } ?>
<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>