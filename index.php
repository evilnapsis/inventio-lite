<?php
include "core/autoload.php";
ob_start();
session_start();

$lb = new Lb();
$lb->loadModule("index");

?>