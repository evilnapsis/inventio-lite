<div class="row">
	<div class="col-md-12">

		<h1>Productos</h1>
<div class="mb-3">
	<a href="index.php?view=newproduct" class="btn btn-primary">Agregar Producto</a>
  <a href="./products-pdf.php" target="_blank" class="btn btn-success text-white"><i class="fa fa-download"></i> Descargar PDF</a>
</div>
<br>

<div class="card">
	<div class="card-header">
		PRODUCTOS
	</div>
		<div class="card-body">

<?php
$products = ProductData::getAll();
if(count($products)>0){
	?>
<br><table class="table table-bordered table-hover">
	<thead>
		<th>Codigo</th>
		<th>Imagen</th>
		<th>Nombre</th>
		<th>Precio Entrada</th>
		<th>Precio Salida</th>
		<th>Categoria</th>
		<th>Minima</th>
		<th>Activo</th>
		<th></th>
	</thead>
  <tbody>
	<?php foreach($products as $product):?>
	<tr>
		<td><?php echo $product->barcode; ?></td>
		<td>
			<?php if($product->image!=""):?>
				<img src="storage/products/<?php echo $product->image;?>" style="width:64px;">
			<?php endif;?>
		</td>
		<td><?php echo $product->name; ?></td>
		<td>$ <?php echo number_format($product->price_in,2,'.',','); ?></td>
		<td>$ <?php echo number_format($product->price_out,2,'.',','); ?></td>
		<td><?php if($product->category_id!=null){echo $product->getCategory()->name;}else{ echo "<center>----</center>"; }  ?></td>
		<td><?php echo $product->inventary_min; ?></td>
		<td><?php if($product->is_active): ?><i class="bi bi-check-lg"></i><?php endif;?></td>
		

		<td style="width:120px;">
		<a href="index.php?view=editproduct&id=<?php echo $product->id; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
		<a href="index.php?view=delproduct&id=<?php echo $product->id; ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
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

<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>