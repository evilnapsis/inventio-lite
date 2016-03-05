<?php


// 14 de Octubre del 2014
// Lb.php
// @brief el objeto legobox
// estoy inspirado : 14/oct/2014 - 0:55am - viendo : un millon de formas de morir en el oeste por 2da vez el dia de hoy
class Lb {

	public function Lb(){
		$this->get = new Get();
		$this->post = new Post();
		$this->request = new Request();
		$this->cookie = new Cookie();
		$this->session = new Session();
	}

	public function loadModule($module){
			if(!isset($_GET['module'])){
				Module::setModule($module);
				include "core/modules/".$module."/autoload.php";
				include "core/modules/".$module."/superboot.php";
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

}

?>