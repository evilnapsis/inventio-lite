<?php if(isset($_GET["id"]) && $_GET["id"]!=""):?>
<?php
$sell = SellData::getById($_GET["id"]);
$operations = OperationData::getAllProductsBySellId($_GET["id"]);
$total = 0;
?>

<h1><i class="bi bi-receipt"></i> Resumen de Compra</h1>
<div class="mb-3">
  <a href="report/onere-pdf.php?id=<?php echo $_GET["id"]; ?>" target="_blank" class="btn btn-success text-white"><i class="bi bi-download"></i> Descargar PDF</a>
  <a href="report/ticket-re.php?id=<?php echo $_GET["id"]; ?>" target="_blank" class="btn btn-primary text-white"><i class="bi bi-receipt"></i> Imprimir Ticket</a>
</div>

<?php
if(isset($_COOKIE["selled"])){
	foreach ($operations as $operation) {
		$qx = OperationData::getQYesF($operation->product_id);
		$p = $operation->getProduct();
		if($qx==0){
			echo "<div class='alert alert-danger'><i class='bi bi-exclamation-octagon-fill me-2'></i>El producto <b style='text-transform:uppercase;'>$p->name</b> no tiene existencias en inventario.</div>";			
		}else if($qx<=$p->inventary_min/2){
			echo "<div class='alert alert-danger'><i class='bi bi-exclamation-octagon-fill me-2'></i>El producto <b style='text-transform:uppercase;'>$p->name</b> tiene muy pocas existencias en inventario.</div>";
		}else if($qx<=$p->inventary_min){
			echo "<div class='alert alert-warning'><i class='bi bi-exclamation-triangle-fill me-2'></i>El producto <b style='text-transform:uppercase;'>$p->name</b> tiene pocas existencias en inventario.</div>";
		}
	}
	setcookie("selled","",time()-18600);
}
?>

<div class="card shadow-sm border-0 mb-4">
	<div class="card-header bg-white py-3">
		<h5 class="card-title mb-0 text-primary fw-bold"><i class="bi bi-info-circle me-2"></i>Información General de la Compra #<?php echo $sell->id; ?></h5>
	</div>
	<div class="card-body">
		<div class="row">
			<!-- Detalle del Documento -->
			<div class="col-md-6 mb-3 mb-md-0">
				<h6 class="text-uppercase fw-bold text-muted small mb-3">Detalle del Documento</h6>
				<table class="table table-borderless table-sm mb-0">
					<tr>
						<td style="width: 120px;" class="fw-bold text-secondary">Folio / ID:</td>
						<td>#<?php echo $sell->id; ?></td>
					</tr>
					<tr>
						<td class="fw-bold text-secondary">Fecha:</td>
						<td><?php echo $sell->created_at; ?></td>
					</tr>
					<?php if($sell->user_id!=""):
						$user = $sell->getUser();
					?>
					<tr>
						<td class="fw-bold text-secondary">Atendido por:</td>
						<td><?php echo $user->name." ".$user->lastname;?></td>
					</tr>
					<?php endif; ?>
				</table>
			</div>
			
			<!-- Información del Proveedor -->
			<div class="col-md-6">
				<h6 class="text-uppercase fw-bold text-muted small mb-3">Información del Proveedor</h6>
				<?php if($sell->person_id!=""):
					$provider = $sell->getPerson();
				?>
				<table class="table table-borderless table-sm mb-0">
					<tr>
						<td style="width: 120px;" class="fw-bold text-secondary">Nombre:</td>
						<td><strong><?php echo $provider->name." ".$provider->lastname;?></strong></td>
					</tr>
					<?php if($provider->phone1 != ""): ?>
					<tr>
						<td class="fw-bold text-secondary">Teléfono:</td>
						<td><?php echo $provider->phone1; ?></td>
					</tr>
					<?php endif; ?>
					<?php if($provider->email1 != ""): ?>
					<tr>
						<td class="fw-bold text-secondary">Email:</td>
						<td><?php echo $provider->email1; ?></td>
					</tr>
					<?php endif; ?>
				</table>
				<?php else: ?>
					<p class="text-muted mb-0"><i class="bi bi-truck me-2"></i>Proveedor no registrado</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<!-- Tabla de Productos -->
<div class="card shadow-sm border-0 mb-4">
	<div class="card-header bg-white py-3">
		<h5 class="card-title mb-0 text-primary fw-bold"><i class="bi bi-box-seam me-2"></i>Productos Comprados</h5>
	</div>
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-sm mb-0">
				<thead>
					<th>Código</th>
					<th>Cantidad</th>
					<th>Nombre del Producto</th>
					<th>Precio Unitario</th>
					<th>Total</th>
				</thead>
				<tbody>
					<?php foreach($operations as $operation):
						$product = $operation->getProduct();
						$subtotal_item = $operation->q * $product->price_in;
						$total += $subtotal_item;
					?>
					<tr>
						<td><?php echo $product->id; ?></td>
						<td><?php echo $operation->q; ?></td>
						<td><?php echo $product->name; ?></td>
						<td>$ <?php echo number_format($product->price_in, 2); ?></td>
						<td><strong>$ <?php echo number_format($subtotal_item, 2); ?></strong></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Resumen de Pago -->
<div class="row justify-content-end">
	<div class="col-md-5 col-lg-4">
		<div class="card shadow-sm border-0">
			<div class="card-body p-0">
				<table class="table table-borderless mb-0">
					<tr class="border-bottom">
						<td class="px-3 py-2 fw-bold text-secondary">Subtotal:</td>
						<td class="px-3 py-2 text-end font-monospace">$ <?php echo number_format($total, 2); ?></td>
					</tr>
					<tr class="border-bottom bg-light fs-5">
						<td class="px-3 py-2 fw-bold text-primary">Total:</td>
						<td class="px-3 py-2 text-end fw-bold text-primary font-monospace">$ <?php echo number_format($total, 2); ?></td>
					</tr>
					<?php if(isset($sell->cash) && $sell->cash > 0): ?>
					<tr class="border-bottom text-success">
						<td class="px-3 py-2 fw-bold">Efectivo Pagado:</td>
						<td class="px-3 py-2 text-end font-monospace">$ <?php echo number_format($sell->cash, 2); ?></td>
					</tr>
					<tr class="text-info">
						<td class="px-3 py-2 fw-bold">Cambio / Vuelto:</td>
						<td class="px-3 py-2 text-end fw-bold font-monospace">$ <?php echo number_format($sell->cash - $total, 2); ?></td>
					</tr>
					<?php endif; ?>
				</table>
			</div>
		</div>
	</div>
</div>

<br><br><br><br><br>
<?php else: ?>
	<div class="alert alert-danger">
		<i class="bi bi-exclamation-triangle-fill me-2"></i> Error 501: Identificador de compra no especificado.
	</div>
<?php endif; ?>
