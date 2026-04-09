<?php
if(isset($_SESSION["cart"])){
	$cart = $_SESSION["cart"];
	if(count($cart)>0){
		$newcart = array();
		foreach($cart as $c){
			if($c["product_id"]!=$_GET["product_id"]){
				$newcart[] = $c;
			}
		}
		$_SESSION["cart"] = $newcart;
	}
}
?>
