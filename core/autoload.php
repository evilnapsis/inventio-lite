<?php

require_once __DIR__ . "/../vendor/autoload.php";

include "controller/Core.php";
include "controller/Database.php";
include "controller/Executor.php";
//# include "controller/Session.php"; [remplazada]

// Actualizacion 2026 : Migracion a Twig + FastRoute (LegoBox)
include "controller/Req.php";
include "controller/Response.php";
include "controller/LbModel.php";
include "controller/ViewEngine.php";

// 10 octubre 2014
include "controller/Model.php";

// 13 octubre 2014
include "controller/Request.php";


// Atualizacion 2026, creado 14 octubre 2014
include "controller/Session.php";

// Actualizacion creado 2026, creado 26 diciembre 2014
include "controller/class.upload.php";


?>