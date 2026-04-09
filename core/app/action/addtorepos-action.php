<?php
$product_id = $_POST["product_id"];
$q_to_add = $_POST["q"];

$cart = isset($_SESSION["reabastecer"]) ? $_SESSION["reabastecer"] : array();
$found = false;
$index = 0;

foreach($cart as $c){
    if($c["product_id"] == $product_id){
        $found = true;
        break;
    }
    $index++;
}

if($found){
    $cart[$index]["q"] += $q_to_add;
} else {
    $cart[] = array("product_id" => $product_id, "q" => $q_to_add);
}
$_SESSION["reabastecer"] = $cart;
echo "success";
?>
