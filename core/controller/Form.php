<?php


// 10 de Octubre del 2014
// Model.php
// @brief agrego la clase Model para reducir las lineas de los modelos

class Form {

	public static function exists($formname){
		$fullpath = self::getFullpath($formname);
		$found=false;
		if(file_exists($fullpath)){
			$found = true;
		}
		return $found;
	}

	public static function getFullpath($formname){
		return "core/modules/".Module::$module."/forms/".$formname.".php";
	}


}



?>