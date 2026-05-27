	<?php
	$found=false;
$products = ProductData::getAll();
$products_array = array();
foreach($products as $product){
	$q=OperationData::getQYesF($product->id);	
	if($q<=$product->inventary_min){
    $products_array[]  = $product;

	}
}
	?>
<div class="row">
	<div class="col-md-12">
		<h1>Bienvenido a Inventio Lite</h1>
</div>
</div>

                    <div class="row">
                      <div class="col-6 col-lg-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-smile"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-primary"><?php echo count(ProductData::getAll());?></div>
                              <div class="text-medium-emphasis text-uppercase fw-semibold small">PRODUCTOS</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2"><a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="./?view=products"><span class="small fw-semibold">IR A PRODUCTOS</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-6 col-lg-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-info text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-info"><?php echo count(PersonData::getClients());?></div>
                              <div class="text-medium-emphasis text-uppercase fw-semibold small">CLIENTES</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2"><a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="./?view=clients"><span class="small fw-semibold">IR A CLIENTES</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-6 col-lg-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-warning text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-truck"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-warning"><?php echo count(PersonData::getProviders());?></div>
                              <div class="text-medium-emphasis text-uppercase fw-semibold small">IR A PROVEEDORES</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2"><a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="./?view=providers"><span class="small fw-semibold">IR A PROVEEDORES</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <div class="col-6 col-lg-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-danger text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-danger"><?php echo count(CategoryData::getAll());?></div>
                              <div class="text-medium-emphasis text-uppercase fw-semibold small">Widget title</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2"><a class="btn-block text-medium-emphasis d-flex justify-content-between align-items-center" href="./?view=categories"><span class="small fw-semibold">IR A CATEGORIAS</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                    </div>
<?php
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

<div class="row mt-4 mb-4">
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

