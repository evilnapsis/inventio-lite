<?php
if(!isset($_SESSION["cart"])){
	$product = array("product_id"=>$_POST["product_id"],"q"=>$_POST["q"]);
	$_SESSION["cart"] = array($product);
}else {
    $found = false;
    $cart = $_SESSION["cart"];
    $index=0;
    foreach($cart as $c){
        if($c["product_id"]==$_POST["product_id"]){
            $found=true;
            break;
        }
        $index++;
    }
    if($found==true){
        $cart[$index]["q"] += $_POST["q"];
        $_SESSION["cart"] = $cart;
    } else {
        $cart[] = array("product_id"=>$_POST["product_id"],"q"=>$_POST["q"]);
        $_SESSION["cart"] = $cart;
    }
}
?>
