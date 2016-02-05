<?php
$debug= true;
if($debug){
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
}

include "core/autoload.php";
ob_start();
session_start();

$lb = new Lb();
$lb->loadModule("index");

?>