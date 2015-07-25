<?php


// 13 de Abril del 2014
// Core.php
// @brief obtiene las configuraciones, muestra y carga los contenidos necesarios.

class Core {

	public static function loadModule($module){
			if(!isset($_GET['module'])){
				Module::setModule($module);
				include "core/modules/".$module."/init.php";
			}else{
				Module::setModule($_GET['module']);
				if(Module::isValid()){
					include "core/modules/".$_GET['module']."/init.php";
				}else {
					Module::Error();
				}
			}

	}

	public static function redir($url){
		echo "<script>window.location=\"$url\";</script>";
	}

}



?>