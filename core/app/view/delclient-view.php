<?php

$client = PersonData::getById($_GET["id"]);
$client->del();
$_SESSION["deleted"] = "Cliente eliminado correctamente";
Core::redir("./index.php?view=clients");

?>
