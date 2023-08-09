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

<br>
<div class="row">
	<div class="col-md-12">
<div class="card">
  <div class="card-header">ALERTAS DE INVENTARIO
  </div>
    <div class="card-body">



<?php 

if(count($products_array)>0){?>
<br><table class="table table-bordered table-hover">
	<thead>
		<th >Codigo</th>
		<th>Nombre del producto</th>
		<th>En Stock</th>
		<th></th>
	</thead>
	<?php
foreach($products as $product):
	$q=OperationData::getQYesF($product->id);
	?>
	<?php if($q<=$product->inventary_min):?>
	<tr class="<?php if($q==0){ echo "danger"; }else if($q<=$product->inventary_min/2){ echo "danger"; } else if($q<=$product->inventary_min){ echo "warning"; } ?>">
		<td><?php echo $product->id; ?></td>
		<td><?php echo $product->name; ?></td>
		<td><?php echo $q; ?></td>
		<td>
		<?php if($q==0){ echo "<span class='label label-danger'>No hay existencias.</span>";}else if($q<=$product->inventary_min/2){ echo "<span class='label label-danger'>Quedan muy pocas existencias.</span>";} else if($q<=$product->inventary_min){ echo "<span class='label label-warning'>Quedan pocas existencias.</span>";} ?>
		</td>
	</tr>
<?php endif;?>
<?php
endforeach;
?>
</table>

<div class="clearfix"></div>

	<?php
}else{
	?>
	<div class="jumbotron">
		<h2>No hay alertas</h2>
		<p>Por el momento no hay alertas de inventario, estas se muestran cuando el inventario ha alcanzado el nivel minimo.</p>
	</div>
	<?php
}

?>
    </div>
</div>
	</div>
</div>