<?php

if(count($_POST)>0){
	$user = new CategoryData();
	$user->name = $_POST["name"];
	$user->add();
	$_SESSION["success"] = "Categoria agregada correctamente";

print "<script>window.location='index.php?view=categories';</script>";


}


?>
