<?php
$products = ProductData::getAll();
$products_array = array();
foreach($products as $product){
	$q = OperationData::getQYesF($product->id);	
	if($q <= $product->inventary_min){
		$products_array[] = $product;
	}
}
?>
<div class="row">
	<div class="col-md-12">
		<h1>Alertas de Inventario</h1>
		
		<?php if(count($products_array) > 0): ?>
			<div class="mb-3">
				<a href="report/alerts-pdf.php" target="_blank" class="btn btn-success text-white">
					<i class="fa fa-download"></i> Descargar PDF
				</a>
			</div>
			
			<div class="card">
				<div class="card-header">ALERTAS DE INVENTARIO</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-sm mb-0">
							<thead>
								<th>Código</th>
								<th>Nombre del producto</th>
								<th>En Stock</th>
								<th>Estado</th>
							</thead>
							<tbody>
								<?php foreach($products as $product):
									$q = OperationData::getQYesF($product->id);
									if($q <= $product->inventary_min):
								?>
								<tr class="<?php if($q==0){ echo "danger"; }else if($q<=$product->inventary_min/2){ echo "danger"; } else if($q<=$product->inventary_min){ echo "warning"; } ?>">
									<td><?php echo $product->id; ?></td>
									<td><?php echo $product->name; ?></td>
									<td><?php echo $q; ?></td>
									<td>
										<?php if($q==0){ echo "<span class='label label-danger'>No hay existencias.</span>";}else if($q<=$product->inventary_min/2){ echo "<span class='label label-danger'>Quedan muy pocas existencias.</span>";} else if($q<=$product->inventary_min){ echo "<span class='label label-warning'>Quedan pocas existencias.</span>";} ?>
									</td>
								</tr>
								<?php endif; endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php else: ?>
			<div class="jumbotron">
				<h2>No hay alertas</h2>
				<p>Por el momento no hay alertas de inventario, estas se muestran cuando el inventario ha alcanzado el nivel mínimo.</p>
			</div>
		<?php endif; ?>
		
	</div>
</div>
