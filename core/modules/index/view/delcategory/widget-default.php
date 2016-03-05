<?php

$category = Categorydata::getById($_GET["id"]);
$products = ProductData::getAllByCategoryId($category->id);
foreach ($products as $product) {
	$product->del_category();
}

$category->del();
Core::redir("./index.php?view=categories");


?>