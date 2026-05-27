<?php
$sells = SellData::getSells();
$total_transactions = count($sells);
$total_gross = 0;
$total_discount = 0;
$total_net = 0;

foreach($sells as $sell) {
	$total_gross += $sell->total;
	$total_discount += $sell->discount;
	$total_net += ($sell->total - $sell->discount);
}
?>

<div class="row">
	<div class="col-md-12">
		<h1><i class="bi bi-cart"></i> Lista de Ventas</h1>
		<div class="clearfix"></div>

		<!-- Tarjetas de Métricas -->
		<div class="row mb-4">
			<div class="col-md-3">
				<div class="card shadow-sm border-0">
					<div class="card-body p-3 d-flex align-items-center">
						<div class="bg-primary text-white p-3 me-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
							<i class="bi bi-receipt fs-4"></i>
						</div>
						<div>
							<div class="fs-5 fw-bold text-primary"><?php echo $total_transactions; ?></div>
							<div class="text-medium-emphasis text-uppercase fw-semibold small" style="font-size: 0.75rem;">Ventas Realizadas</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card shadow-sm border-0">
					<div class="card-body p-3 d-flex align-items-center">
						<div class="bg-info text-white p-3 me-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
							<i class="bi bi-currency-dollar fs-4"></i>
						</div>
						<div>
							<div class="fs-5 fw-bold text-info">$<?php echo number_format($total_gross, 2); ?></div>
							<div class="text-medium-emphasis text-uppercase fw-semibold small" style="font-size: 0.75rem;">Subtotal Bruto</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card shadow-sm border-0">
					<div class="card-body p-3 d-flex align-items-center">
						<div class="bg-danger text-white p-3 me-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
							<i class="bi bi-percent fs-4"></i>
						</div>
						<div>
							<div class="fs-5 fw-bold text-danger">$<?php echo number_format($total_discount, 2); ?></div>
							<div class="text-medium-emphasis text-uppercase fw-semibold small" style="font-size: 0.75rem;">Descuentos Aplicados</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card shadow-sm border-0">
					<div class="card-body p-3 d-flex align-items-center">
						<div class="bg-success text-white p-3 me-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
							<i class="bi bi-cash-stack fs-4"></i>
						</div>
						<div>
							<div class="fs-5 fw-bold text-success">$<?php echo number_format($total_net, 2); ?></div>
							<div class="text-medium-emphasis text-uppercase fw-semibold small" style="font-size: 0.75rem;">Total Neto Cobrado</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Tabla de Ventas -->
		<div class="card">
			<div class="card-header">VENTAS</div>
			<div class="card-body p-0">
				<?php if(count($sells) > 0): ?>
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-sm mb-0">
							<thead>
								<th>Folio/ID</th>
								<th>Cliente</th>
								<th>Atendido Por</th>
								<th>Productos</th>
								<th>Descuento</th>
								<th>Total Neto</th>
								<th>Fecha</th>
								<th>Acciones</th>
							</thead>
							<tbody>
								<?php foreach($sells as $sell):
									$client_name = "Público General";
									if($sell->person_id != "") {
										$client = $sell->getPerson();
										if($client != null) {
											$client_name = $client->name . " " . $client->lastname;
										}
									}
									
									$user_name = "Sistema";
									if($sell->user_id != "") {
										$user = $sell->getUser();
										if($user != null) {
											$user_name = $user->name . " " . $user->lastname;
										}
									}
									
									$operations = OperationData::getAllProductsBySellId($sell->id);
									$items_count = 0;
									foreach($operations as $op) {
										$items_count += $op->q;
									}
								?>
								<tr>
									<td>#<?php echo $sell->id; ?></td>
									<td><?php echo $client_name; ?></td>
									<td><?php echo $user_name; ?></td>
									<td>
										<span class="badge bg-secondary"><?php echo count($operations); ?> ref.</span>
										<small class="text-muted">(<?php echo $items_count; ?> uds.)</small>
									</td>
									<td>$ <?php echo number_format($sell->discount, 2); ?></td>
									<td><strong>$ <?php echo number_format($sell->total - $sell->discount, 2); ?></strong></td>
									<td><?php echo $sell->created_at; ?></td>
									<td style="width: 170px;">
										<div class="btn-group">
											<a href="index.php?view=onesell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-info text-white" title="Ver Detalle">
												<i class="bi bi-eye"></i> Detalle
											</a>
											<a href="report/ticket.php?id=<?php echo $sell->id; ?>" target="_blank" class="btn btn-xs btn-primary text-white" title="Imprimir Ticket">
												<i class="bi bi-receipt"></i> Ticket
											</a>
											<a href="index.php?view=delsell&id=<?php echo $sell->id; ?>" id="del-<?php echo $sell->id; ?>" class="btn btn-xs btn-danger text-white" title="Eliminar">
												<i class="bi bi-trash"></i>
											</a>
										</div>
										
										<script>
											$("#del-<?php echo $sell->id; ?>").click(function(e){
												e.preventDefault();
												var c = confirm("¿Estás completamente seguro de que deseas eliminar esta venta? Esta acción no se puede deshacer y afectará el inventario/caja.");
												if(c) {
													window.location.href = $(this).attr("href");
												}
											});
										</script>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php else: ?>
					<div class="p-4 text-center">
						<div class="jumbotron m-0">
							<h2>No hay ventas</h2>
							<p>No se ha realizado ninguna venta en el sistema.</p>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
