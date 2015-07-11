<?php

if(count($_POST)>0){
	echo "ok";
	$product = ProductData::getById($_POST["product_id"]);
	$product->name = $_POST["name"];
	$product->price_in = $_POST["price_in"];
	$product->price_out = $_POST["price_out"];
	$product->unit = $_POST["unit"];
	$product->presentation = $_POST["presentation"];
	$product->user_id = Session::getUID();
	$product->update();
	setcookie("prdupd","true");
	print "<script>window.location='index.php?view=editproduct&id=$_POST[product_id]';</script>";


}


?>