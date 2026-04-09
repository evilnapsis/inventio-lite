<div class="row">
	<div class="col-md-12">
<!-- Single button -->

		<h1><i class="glyphicon glyphicon-stats"></i> Inventario de Productos</h1>
<div class="mb-3">
	<a href="report/inventary-pdf.php" target="_blank" class="btn btn-success text-white"><i class="fa fa-download"></i> Descargar PDF</a>
</div>
		<div class="clearfix"></div>
		<br>
<div class="card">
	<div class="card-header">INVENTARIO
	</div>
		<div class="card-body">




<?php
$products = ProductData::getAll();
if(count($products)>0){
	?>
<br><table class="table table-bordered table-hover">
	<thead>
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Disponible</th>
		<th></th>
	</thead>
  <tbody>
	<?php foreach($products as $product):
	$q=OperationData::getQYesF($product->id);
	?>
	<tr class="<?php if($q<=$product->inventary_min/2){ echo "danger";}else if($q<=$product->inventary_min){ echo "warning";}?>">
		<td><?php echo $product->id; ?></td>
		<td><?php echo $product->name; ?></td>
		<td>
			<?php echo $q; ?>
		</td>
		<td style="width:93px;">
		<a href="index.php?view=history&product_id=<?php echo $product->id; ?>" class="btn btn-xs btn-success"><i class="bi bi-clock-history"></i> Historial</a>
		</td>
	</tr>
	<?php endforeach;?>
  </tbody>
</table>
<div class="clearfix"></div>
<?php
}else{
	?>
	<div class="jumbotron">
		<h2>No hay productos</h2>
		<p>No se han agregado productos a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Producto"</b>.</p>
	</div>
	<?php
}

?>
		</div>
</div>
	</div>
</div>
