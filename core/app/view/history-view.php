<?php
if(isset($_GET["product_id"])):
$product = ProductData::getById($_GET["product_id"]);
$operations = OperationData::getAllByProductId($product->id);
?>
<div class="row">
	<div class="col-md-12">


<h1><?php echo $product->name;; ?> <small>Historial</small></h1>


	</div>
	</div>

<div class="row">


	<div class="col-md-4">


	<?php
$itotal = OperationData::GetInputQYesF($product->id);

	?>

<?php
?>

</div>

	<div class="col-md-4">
	<?php
$total = OperationData::GetQYesF($product->id);


	?>



<?php
?>

</div>

	<div class="col-md-4">


	<?php
$ototal = -1*OperationData::GetOutputQYesF($product->id);

	?>



<?php
?>

</div>
</div>
<div class="row">
                      <div class="col-6 col-lg-4">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-truck"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-primary"><?php echo $itotal; ?></div>
                              <div class="text-medium-emphasis text-uppercase fw-semibold small">ENTRADAS</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-6 col-lg-4">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-success text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-check"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-success"><?php echo $total; ?></div>
                              <div class="text-medium-emphasis text-uppercase fw-semibold small">DISPONIBLE</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-6 col-lg-4">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-warning text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cart"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-warning"><?php echo $ototal; ?></div>
                              <div class="text-medium-emphasis text-uppercase fw-semibold small">SALIDAS</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->

                      <!-- /.col-->
                    </div>
<br>
<div class="row">
	<div class="col-md-12">
<div class="card">
	<div class="card-header">
		HISTORIAL
	</div>
		<div class="card-body">


		<?php if(count($operations)>0):?>
			<table class="table table-bordered table-hover">
			<thead>
			<th></th>
			<th>Cantidad</th>
			<th>Tipo</th>
			<th>Fecha</th>
			<th></th>
			</thead>
			<?php foreach($operations as $operation):?>
			<tr>
			<td></td>
			<td><?php echo $operation->q; ?></td>
			<td><?php echo $operation->getOperationType()->name; ?></td>
			<td><?php echo $operation->created_at; ?></td>
			<td style="width:40px;"><a href="#" id="oper-<?php echo $operation->id; ?>" class="btn tip btn-sm btn-danger" title="Eliminar"><i class="bi  bi-trash"></i></a> </td>
			<script>
			$("#oper-"+<?php echo $operation->id; ?>).click(function(){
				x = confirm("Estas seguro que quieres eliminar esto ??");
				if(x==true){
					window.location = "index.php?view=deleteoperation&ref=history&pid=<?php echo $operation->product_id;?>&opid=<?php echo $operation->id;?>";
				}
			});

			</script>
			</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
		</div>
</div>

	</div>
</div>

<?php endif; ?>