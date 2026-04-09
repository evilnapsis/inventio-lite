<?php

$category = Categorydata::getById($_GET["id"]);
$products = ProductData::getAllByCategoryId($category->id);
foreach ($products as $product) {
	$product->del_category();
}

$category->del();
$_SESSION["deleted"] = "Categoria eliminada correctamente";
Core::redir("./index.php?view=categories");


?>
