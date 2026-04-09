<?php

$client = PersonData::getById($_GET["id"]);
$client->del();
$_SESSION["deleted"] = "Proveedor eliminado correctamente";
Core::redir("./index.php?view=providers");

?>
