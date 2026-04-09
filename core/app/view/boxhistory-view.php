<div class="row">
	<div class="col-md-12">
<!-- Single button -->
		<h1><i class='bi bi-archive'></i> Historial de Caja</h1>
<div class="mb-3">
	<a href="report/boxhistory-pdf.php" target="_blank" class="btn btn-success text-white"><i class="bi bi-download"></i> Descargar PDF</a>
</div>
<br>
		<div class="clearfix"></div>
<div class="card">
	<div class="card-header">
		HISTORIAL DE CAJA
	</div>
		<div class="card-body">



<?php
$boxes = BoxData::getAll();
$products = SellData::getSellsUnBoxed();
if(count($boxes)>0){
$total_total = 0;
?>
<br>
<table class="table table-bordered table-hover	">
	<thead>
		<th></th>
		<th>Total</th>
		<th>Fecha</th>
	</thead>
	<tbody>
	<?php foreach($boxes as $box):
$sells = SellData::getByBoxId($box->id);

	?>

	<tr>
		<td style="width:30px;">
<a href="./index.php?view=b&id=<?php echo $box->id; ?>" class="btn btn-secondary btn-sm"><i class="bi bi-eye"></i></a>			
		</td>
		<td>

<?php
$total=0;
foreach($sells as $sell){
$operations = OperationData::getAllProductsBySellId($sell->id);
	foreach($operations as $operation){
		$product  = $operation->getProduct();
		$total += $operation->q*$product->price_out;
	}
}
		$total_total += $total;
		echo "<b>$ ".number_format($total,2,".",",")."</b>";

?>			

		</td>
		<td><?php echo $box->created_at; ?></td>
	</tr>

<?php endforeach; ?>
	</tbody>
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
</div>
</div>
<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
