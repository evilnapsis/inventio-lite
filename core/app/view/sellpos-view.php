<div class="row">
	<div class="col-md-12">
    <div class="card mb-4">
      <div class="card-body">
        <h1>Punto de Venta</h1>
        <p><b>Buscar producto por nombre o por código:</b></p>
        <form id="searchp" onsubmit="return false;">
          <input type="hidden" name="view" value="sellpos">
          <div class="row">
            <div class="col-md-10">
              <input type="text" id="product_code" name="product" class="form-control" autocomplete="off" placeholder="Escriba el nombre o código del producto...">
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Buscar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
	</div>
</div>

<div class="row">
  <div class="col-md-9">
    <div class="card">
      <div class="card-header">PRODUCTOS</div>
      <div class="card-body">
        <div id="show_search_results" class="row">
          <!-- Aquí se cargarán los productos en cuadrícula -->
          <div class="col-md-12 text-center text-muted">
            <p><i class="bi bi-cart4" style="font-size: 3rem;"></i></p>
            <p>Realice una búsqueda para comenzar.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div id="cart_summary">
      <!-- Aquí se cargará el resumen del carrito via AJAX -->
      <div class="card">
        <div class="card-header">RESUMEN</div>
        <div class="card-body text-center text-muted">
          <p>Cargando carrito...</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  // Cargar carrito al iniciar
  updateCart();

	$("#searchp").on("submit",function(e){
		e.preventDefault();
		searchProducts();
    return false;
	});

  var typingTimer;
  var doneTypingInterval = 500;

  $("#product_code").on("keyup", function () {
    clearTimeout(typingTimer);
    if ($(this).val().length > 2) {
      typingTimer = setTimeout(searchProducts, doneTypingInterval);
    }
  });

  function searchProducts(){
    var q = $("#product_code").val();
    if(q==""){ return; }
    $.get("./?action=searchproductpos", {product: q}, function(data){
			$("#show_search_results").html(data);
		});
  }

  function addToCart(product_id){
    var q = $("#q-"+product_id).val();
    $.post("./?action=addtocartpos", {product_id: product_id, q: q}, function(data){
      updateCart();
    });
  }
  window.addToCart = addToCart;

  function updateCart(){
    $.get("./?action=cartpos", function(data){
      $("#cart_summary").html(data);
    });
  }
  window.updateCart = updateCart;

  function deleteFromCart(product_id){
    $.get("./?action=delfromcartpos", {product_id: product_id}, function(data){
      updateCart();
    });
  }
  window.deleteFromCart = deleteFromCart;
});
</script>
