<?php
if(isset($_GET["product_id"])):
$product = ProductData::getById($_GET["product_id"]);
$operations = OperationData::getAllByProductIdCutId($product->id,$cut->id);
?>
<div class="row">
	<div class="col-md-12">
<a href="" class="btn btn-default pull-right btn-lg">Sin Factura</a>

<h1><?php echo $product->name;; ?> <small>Operaciones con factura</small></h1>
	</div>
	</div>

<div class="row">
	<div class="col-md-4">
	<?php
$total = OperationData::GetQ($product->id,$cut->id);
$no_oficial = OperationData::GetQNoF($product->id,$cut->id);
$oficial = OperationData::GetQYesF($product->id,$cut->id);

$nof100=0;
$of100 =0;

if($no_oficial>0){$nof100 = $no_oficial/$total;}
if($oficial>0){$of100 = $oficial/$total;}
	?>
	<h1 class="pull-right"><?php echo $total; ?></h1>
	<h2>General</h2>

<div class="clearfix"></div>
<div class="progress">
  <a title='Facturado' class="progress-bar progress-bar-primary" style="width: <?php echo $of100*100; ?>%">
  </a>
  <a title="No Facturado" class="progress-bar progress-bar-success" style="width: <?php echo $nof100*100; ?>%">
  </a>
</div>
<div><span class="label label-primary">Facturado</span> <?php echo $oficial; ?> = <b><?php echo $of100*100; ?>%</b> </div>
<div><span class="label label-success">No Facturado</span> <?php echo $no_oficial; ?> = <b><?php echo $nof100*100; ?>%</b> </div>
<div class="clearfix"></div>
<br>
<?php
?>

</div>

	<div class="col-md-4">


	<?php
$itotal = OperationData::GetInputQ($product->id,$cut->id);
$ino_oficial = OperationData::GetInputQNoF($product->id,$cut->id);
$ioficial = OperationData::GetInputQYesF($product->id,$cut->id);

$nof100=0;
$of100 =0;

if($ino_oficial>0){$nof100 = $ino_oficial/$itotal;}
if($ioficial>0){$of100 = $ioficial/$itotal;}


	?>
	<h1 class="pull-right"><?php echo $itotal; ?></h1>
	<h2>Entradas</h2>

<div class="clearfix"></div>
<div class="progress">
  <a title='Facturado' class="progress-bar progress-bar-primary" style="width: <?php echo $of100*100; ?>%">
  </a>
  <a title="No Facturado" class="progress-bar progress-bar-success" style="width: <?php echo $nof100*100; ?>%">
  </a>
</div>
<div><span class="label label-primary">Facturado</span> <?php echo $ioficial; ?> = <b><?php echo $of100*100; ?>%</b> </div>
<div><span class="label label-success">No Facturado</span> <?php echo $ino_oficial; ?> = <b><?php echo $nof100*100; ?>%</b> </div>
<div class="clearfix"></div>
<br>
<?php
?>

</div>


	<div class="col-md-4">


	<?php
$ototal = -1*OperationData::GetOutputQ($product->id,$cut->id);
$ono_oficial = -1*OperationData::GetOutputQNoF($product->id,$cut->id);
$ooficial = -1*OperationData::GetOutputQYesF($product->id,$cut->id);

$nof100=0;
$of100 =0;

if($ono_oficial>0){$nof100 = $ono_oficial/$ototal;}
if($ooficial>0){$of100 = $ooficial/$ototal;}
	?>
	<h1 class="pull-right"><?php echo $ototal; ?></h1>
	<h2>Salidas</h2>

<div class="clearfix"></div>
<div class="progress">
  <a title='Facturado' class="progress-bar progress-bar-primary" style="width: <?php echo $of100*100; ?>%">
  </a>
  <a title="No Facturado" class="progress-bar progress-bar-success" style="width: <?php echo $nof100*100; ?>%">
  </a>
</div>
<div><span class="label label-primary">Facturado</span> <?php echo $ooficial; ?> = <b><?php echo $of100*100; ?>%</b> </div>
<div><span class="label label-success">No Facturado</span> <?php echo $ono_oficial; ?> = <b><?php echo $nof100*100; ?>%</b> </div>
<div class="clearfix"></div>
<br>
<?php
?>

</div>






</div>
<div class="row">
	<div class="col-md-12">
		<p class="alert alert-success"> Se esta trabajando sobre el corte iniciado la fecha (AAAA-MM-DD HH:MM:SS): <b><?php echo $cut->created_at; ?></b></p>
		<?php if(count($operations)>0):?>
			<table class="table table-bordered table-hover">
			<thead>
			<th></th>
			<th>Cantidad</th>
			<th>Con factura</th>
			<th>Tipo</th>
			<th>Fecha</th>
			</thead>
			<?php foreach($operations as $operation):?>
			<tr>
			<td></td>
			<td><?php echo $operation->q; ?></td>
			<td>
			<center>
				<?php if($operation->is_oficial==1):?>
					<i class="glyphicon glyphicon-ok-sign"></i>
				<?php else:?>
					<i class="glyphicon glyphicon-remove"></i>
				<?php endif; ?>
			</center>

			</td>
			<td><?php echo $operation->getOperationType()->name; ?></td>
			<td><?php echo $operation->created_at; ?></td>
			</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
</div>

<?php endif; ?>