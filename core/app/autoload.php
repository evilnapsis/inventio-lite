<?php
// autoload.php
// 10 octubre del 2014
// esta funcion elimina el hecho de estar agregando los modelos manualmente


function il_autoload($modelname){
	if(Model::exists($modelname)){
		include Model::getFullPath($modelname);
		return;
	}

	// Fallback para las clases nuevas App\Controller\* / App\Service\* (LegoBox)
	if(strpos($modelname, 'App\\') === 0){
		$parts = explode('\\', $modelname);
		if(count($parts) >= 3){
			$subfolder = strtolower($parts[1]); // 'controller' o 'service'
			$classname = $parts[2];
			$fullpath = __DIR__ . "/" . $subfolder . "/" . $classname . ".php";
			if(file_exists($fullpath)){
				include $fullpath;
			}
		}
	}
}


spl_autoload_register("il_autoload");

?>