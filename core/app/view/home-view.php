<?php
$products = ProductData::getAll();
$products_array = array();
foreach($products as $product){
	$q = OperationData::getQYesF($product->id);	
	if($q <= $product->inventary_min){
		$products_array[] = $product;
	}
}

$sells_30_days = SellData::getSellsLast30Days();
$sells_by_date = array();
foreach ($sells_30_days as $sell) {
	$sells_by_date[$sell->date] = $sell->total;
}

$labels = array();
$data = array();
for ($i = 29; $i >= 0; $i--) {
	$date = date("Y-m-d", strtotime("-$i days"));
	$labels[] = date("d/m", strtotime($date));
	$data[] = isset($sells_by_date[$date]) ? floatval($sells_by_date[$date]) : 0;
}
?>

<div class="row">
	<div class="col-md-12">
		<h1 class="mb-4">Dashboard</h1>
	</div>
</div>

<!-- Tarjetas de Conteo Rediseñadas -->
<div class="row g-3 mb-4">
	<!-- Card Productos -->
	<div class="col-6 col-lg-3">
		<a href="./?view=products" class="text-decoration-none text-dark">
			<div class="card shadow-sm border-0 h-100 card-hover" style="border-left: 4px solid #5856d6 !important;">
				<div class="card-body p-4 d-flex align-items-center justify-content-between">
					<div>
						<div class="fs-3 fw-bold text-primary"><?php echo count($products);?></div>
						<div class="text-uppercase fw-bold text-muted small">Productos</div>
					</div>
					<div class="text-primary opacity-50">
						<i class="bi bi-box-seam fs-1"></i>
					</div>
				</div>
			</div>
		</a>
	</div>
	<!-- Card Clientes -->
	<div class="col-6 col-lg-3">
		<a href="./?view=clients" class="text-decoration-none text-dark">
			<div class="card shadow-sm border-0 h-100 card-hover" style="border-left: 4px solid #39f !important;">
				<div class="card-body p-4 d-flex align-items-center justify-content-between">
					<div>
						<div class="fs-3 fw-bold text-info"><?php echo count(PersonData::getClients());?></div>
						<div class="text-uppercase fw-bold text-muted small">Clientes</div>
					</div>
					<div class="text-info opacity-50">
						<i class="bi bi-people fs-1"></i>
					</div>
				</div>
			</div>
		</a>
	</div>
	<!-- Card Proveedores -->
	<div class="col-6 col-lg-3">
		<a href="./?view=providers" class="text-decoration-none text-dark">
			<div class="card shadow-sm border-0 h-100 card-hover" style="border-left: 4px solid #f9b115 !important;">
				<div class="card-body p-4 d-flex align-items-center justify-content-between">
					<div>
						<div class="fs-3 fw-bold text-warning"><?php echo count(PersonData::getProviders());?></div>
						<div class="text-uppercase fw-bold text-muted small">Proveedores</div>
					</div>
					<div class="text-warning opacity-50">
						<i class="bi bi-truck fs-1"></i>
					</div>
				</div>
			</div>
		</a>
	</div>
	<!-- Card Categorías -->
	<div class="col-6 col-lg-3">
		<a href="./?view=categories" class="text-decoration-none text-dark">
			<div class="card shadow-sm border-0 h-100 card-hover" style="border-left: 4px solid #e55353 !important;">
				<div class="card-body p-4 d-flex align-items-center justify-content-between">
					<div>
						<div class="fs-3 fw-bold text-danger"><?php echo count(CategoryData::getAll());?></div>
						<div class="text-uppercase fw-bold text-muted small">Categorías</div>
					</div>
					<div class="text-danger opacity-50">
						<i class="bi bi-tags fs-1"></i>
					</div>
				</div>
			</div>
		</a>
	</div>
</div>

<!-- Gráfica de Ventas -->
<div class="row mb-4">
	<div class="col-md-12">
		<div class="card shadow-sm border-0">
			<div class="card-header bg-white py-3">
				<h5 class="card-title mb-0 fw-bold text-primary"><i class="bi bi-graph-up me-2"></i>Ventas de los últimos 30 días</h5>
			</div>
			<div class="card-body">
				<div style="position: relative; height: 300px; width: 100%;">
					<canvas id="salesChart"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Actividad Reciente (Últimas Ventas y Productos Recientes) -->
<div class="row">
	<!-- Últimas Ventas -->
	<div class="col-md-6 mb-4">
		<div class="card shadow-sm border-0 h-100">
			<div class="card-header bg-white py-3">
				<h5 class="card-title mb-0 text-primary fw-bold"><i class="bi bi-cart-check me-2"></i>Últimas Ventas</h5>
			</div>
			<div class="card-body p-0">
				<?php 
				$recent_sells = array_slice(SellData::getSells(), 0, 5);
				if(count($recent_sells) > 0):
				?>
				<div class="table-responsive">
					<table class="table table-hover table-sm mb-0">
						<thead>
							<th>ID</th>
							<th>Cliente</th>
							<th>Total</th>
							<th>Fecha</th>
						</thead>
						<tbody>
							<?php foreach($recent_sells as $sell): 
								$client_name = "Público General";
								if($sell->person_id != "") {
									$client = $sell->getPerson();
									if($client != null) {
										$client_name = $client->name . " " . $client->lastname;
									}
								}
							?>
							<tr>
								<td><a href="index.php?view=onesell&id=<?php echo $sell->id; ?>" class="fw-bold text-decoration-none">#<?php echo $sell->id; ?></a></td>
								<td><?php echo $client_name; ?></td>
								<td><strong>$ <?php echo number_format($sell->total - $sell->discount, 2); ?></strong></td>
								<td><small class="text-muted"><?php echo $sell->created_at; ?></small></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?php else: ?>
					<p class="text-muted p-3 mb-0">No hay ventas registradas.</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- Últimos Productos -->
	<div class="col-md-6 mb-4">
		<div class="card shadow-sm border-0 h-100">
			<div class="card-header bg-white py-3">
				<h5 class="card-title mb-0 text-primary fw-bold"><i class="bi bi-box-seam me-2"></i>Productos Agregados Recientemente</h5>
			</div>
			<div class="card-body p-0">
				<?php 
				$all_prods = ProductData::getAll();
				usort($all_prods, function($a, $b) {
					return $b->id - $a->id;
				});
				$recent_prods = array_slice($all_prods, 0, 5);
				if(count($recent_prods) > 0):
				?>
				<div class="table-responsive">
					<table class="table table-hover table-sm mb-0">
						<thead>
							<th>Código</th>
							<th>Nombre</th>
							<th>Precio</th>
							<th>Categoría</th>
						</thead>
						<tbody>
							<?php foreach($recent_prods as $prod): 
								$cat_name = "Sin categoría";
								if($prod->category_id != "") {
									$cat = $prod->getCategory();
									if($cat != null) {
										$cat_name = $cat->name;
									}
								}
							?>
							<tr>
								<td><?php echo $prod->id; ?></td>
								<td><span class="fw-bold"><?php echo $prod->name; ?></span></td>
								<td>$ <?php echo number_format($prod->price_out, 2); ?></td>
								<td><span class="badge bg-secondary"><?php echo $cat_name; ?></span></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?php else: ?>
					<p class="text-muted p-3 mb-0">No hay productos registrados.</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<script src="vendors/chart.js/js/chart.min.js"></script>
<script>
  $(document).ready(function() {
    var ctx = document.getElementById('salesChart').getContext('2d');
    
    var gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(88, 86, 214, 0.3)');
    gradient.addColorStop(1, 'rgba(88, 86, 214, 0.0)');

    var salesChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
          label: 'Total Ventas',
          data: <?php echo json_encode($data); ?>,
          backgroundColor: gradient,
          borderColor: '#5856d6',
          borderWidth: 3,
          pointBackgroundColor: '#5856d6',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: '#5856d6',
          pointRadius: 4,
          pointHoverRadius: 6,
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            mode: 'index',
            intersect: false,
            backgroundColor: '#1e1e2f',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderColor: '#5856d6',
            borderWidth: 1,
            padding: 10,
            displayColors: false,
            callbacks: {
              label: function(context) {
                var label = context.dataset.label || '';
                if (label) {
                  label += ': ';
                }
                if (context.parsed.y !== null) {
                  label += new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(context.parsed.y);
                }
                return label;
              }
            }
          }
        },
        scales: {
          x: {
            grid: {
              display: false
            },
            ticks: {
              color: '#8a93a2'
            }
          },
          y: {
            grid: {
              color: 'rgba(138, 147, 162, 0.1)',
              borderDash: [5, 5]
            },
            ticks: {
              color: '#8a93a2',
              callback: function(value, index, values) {
                return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', maximumFractionDigits: 0 }).format(value);
              }
            }
          }
        }
      }
    });
  });
</script>
