<?php
if(isset($_GET["product_id"])){
	$cart=$_SESSION["reabastecer"];
	if(count($cart)==1){
	 unset($_SESSION["reabastecer"]);
	}else{
		$ncart = null;
		$nx=0;
		foreach($cart as $c){
			if($c["product_id"]!=$_GET["product_id"]){
				$ncart[$nx]= $c;
			}
			$nx++;
		}
		$_SESSION["reabastecer"] = $ncart;
	}

}else{
 unset($_SESSION["reabastecer"]);
}

print "<script>window.location='index.php?view=re';</script>";

?>