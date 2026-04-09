<?php
$total = 0;
$cart = isset($_SESSION["reabastecer"]) ? $_SESSION["reabastecer"] : array();
?>
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-8">LISTA DE COMPRA</div>
      <div class="col-4 text-end">
        <a href="index.php?view=clearrepos" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
      </div>
    </div>
  </div>
  <div class="card-body p-0">
    <?php if(count($cart)>0): ?>
      <table class="table table-sm table-hover mb-0">
        <thead>
          <tr class="bg-light">
            <th>Cant.</th>
            <th>Producto</th>
            <th class="text-end">Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($cart as $p):
            $product = ProductData::getById($p["product_id"]);
          ?>
          <tr>
            <td><?php echo $p["q"]; ?></td>
            <td class="small"><?php echo $product->name; ?></td>
            <td class="text-end fw-bold">$ <?php 
              $pt = $product->price_in * $p["q"]; 
              $total += $pt; 
              echo number_format($pt, 2); 
            ?></td>
            <td class="text-end">
              <button class="btn btn-link btn-sm text-danger p-0" onclick="deleteFromCart(<?php echo $product->id; ?>)">
                <i class="bi bi-x-circle"></i>
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      
      <div class="p-3 bg-light border-top">
        <div class="d-flex justify-content-between h5 mt-2 pt-2 border-top">
          <span class="fw-bold">TOTAL:</span>
          <span class="fw-bold text-success">$ <?php echo number_format($total, 2); ?></span>
        </div>
      </div>

      <div class="p-3">
        <form method="post" id="processrepos" action="index.php?view=processrepos">
          <div class="mb-3">
            <label class="form-label small">Proveedor</label>
            <?php $providers = PersonData::getProviders(); ?>
            <select name="client_id" class="form-select form-select-sm">
              <option value="">-- NINGUNO --</option>
              <?php foreach($providers as $provider):?>
                <option value="<?php echo $provider->id;?>"><?php echo $provider->name." ".$provider->lastname;?></option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small text-primary fw-bold">Efectivo Pagado</label>
            <input type="number" name="money" required class="form-control" id="money_repos" step="0.01">
          </div>
          <input type="hidden" name="total" value="<?php echo $total; ?>">
          <button type="submit" class="btn btn-success w-100">
            <i class="bi bi-check-circle me-1"></i> PROCESAR COMPRA
          </button>
        </form>
      </div>
    <?php else: ?>
      <div class="p-5 text-center text-muted">
        <i class="bi bi-cart-x" style="font-size: 3rem;"></i>
        <p class="mt-2">La lista está vacía.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
	$("#processrepos").submit(function(e){
		var money = $("#money_repos").val();
    var total = <?php echo $total; ?>;
		if(parseFloat(money) < total){
			Swal.fire('Error', 'El efectivo pagado es insuficiente.', 'error');
			e.preventDefault();
		}else{
      var cambio = parseFloat(money) - total;
      e.preventDefault();
      Swal.fire({
        title: 'Confirmar Compra',
        text: 'Cambio: $' + cambio.toFixed(2),
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      });
		}
	});
</script>
