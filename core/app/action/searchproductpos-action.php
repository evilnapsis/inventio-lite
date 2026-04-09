<?php if(isset($_GET["product"]) && $_GET["product"]!=""):?>
	<?php
$products = ProductData::getLike($_GET["product"]);
if(count($products)>0){
	?>
	<?php
$products_in_cero=0;
	 foreach($products as $product):
$q= OperationData::getQYesF($product->id);
	?>
	<?php 
	if($q>0):?>
		
    <div class="col-md-2 mb-3">
      <div class="card h-100 <?php if($q<=$product->inventary_min){ echo "border-danger"; }?>">
        <?php if($product->image!=""):?>
          <img src="storage/products/<?php echo $product->image;?>" class="card-img-top" style="height: 100px; object-fit: cover;">
        <?php else:?>
          <div class="bg-light text-center py-2" style="height: 100px;">
            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
          </div>
        <?php endif;?>
        <div class="card-body p-1">
          <h6 class="card-title mb-1 text-truncate small" title="<?php echo $product->name; ?>"><?php echo $product->name; ?></h6>
          <p class="card-text mb-1" style="font-size: 0.75rem;">Stock: <b><?php echo $q; ?></b></p>
          <p class="card-text fw-bold text-primary mb-2" style="font-size: 0.85rem;">$ <?php echo number_format($product->price_out,2); ?></p>
          
          <div class="input-group input-group-sm">
            <input type="number" id="q-<?php echo $product->id; ?>" class="form-control" value="1" min="1" max="<?php echo $q; ?>">
            <button class="btn btn-primary" onclick="addToCart(<?php echo $product->id; ?>)">
              <i class="bi bi-plus-lg"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
	
<?php else:$products_in_cero++;
?>
<?php  endif; ?>
	<?php endforeach;?>

<?php if($products_in_cero>0):?>
  <div class="col-md-12">
    <div class="alert alert-warning py-2 small">
      Se omitieron <b><?php echo $products_in_cero; ?> productos</b> sin existencias.
    </div>
  </div>
<?php endif;?>

	<?php
}else{
	echo "<div class='col-md-12'><p class='alert alert-danger'>No se encontró el producto</p></div>";
}
?>
<?php endif; ?>
