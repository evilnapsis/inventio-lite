<?php
// el archivo autoload inicializa todos lo archivos necesarios para que el framework funcione
define("ROOT", "slidle");
include "core/autoload.php";

// cargamos el modulo iniciar.
Core::loadModule("ventas");

?>