<?php

$operations = OperationData::getAllByProductId($_GET["id"]);

foreach ($operations as $op) {
	$op->del();
}

$product = ProductData::getById($_GET["id"]);
$product->del();

$_SESSION["deleted"] = "Producto eliminado correctamente";
Core::redir("./index.php?view=products");
?>
