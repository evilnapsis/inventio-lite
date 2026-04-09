<?php
$product_id = $_POST["product_id"];
$q_to_add = $_POST["q"];
$q_inventory = OperationData::getQYesF($product_id);

$cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : array();
$found = false;
$index = 0;
$q_in_cart = 0;

foreach($cart as $c){
    if($c["product_id"] == $product_id){
        $found = true;
        $q_in_cart = $c["q"];
        break;
    }
    $index++;
}

if(($q_in_cart + $q_to_add) <= $q_inventory){
    if($found){
        $cart[$index]["q"] += $q_to_add;
    } else {
        $cart[] = array("product_id" => $product_id, "q" => $q_to_add);
    }
    $_SESSION["cart"] = $cart;
    echo "success";
} else {
    echo "error_insufficient_stock";
}
?>
