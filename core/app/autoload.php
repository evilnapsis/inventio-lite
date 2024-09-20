<?php
// autoload.php
// 10 octubre del 2014
// esta funcion elimina el hecho de estar agregando los modelos manualmente


function il_autoload($modelname){
	if(Model::exists($modelname)){
		include Model::getFullPath($modelname);
	} 

}


spl_autoload_register("il_autoload");

?>