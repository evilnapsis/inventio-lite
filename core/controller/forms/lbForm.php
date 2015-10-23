<?php

class lbForm {
	public function lbForm(){
		$this->field = array();
	}

	public function addField($name,$field){
		$this->field[$name] = $field;
	}

	public function render($field){
		return $this->getField($field)->render();

	}

	public function label($field){
		return $this->getField($field)->renderLabel();

	}


	public function getField($name){
		$field = $this->field[$name]['type'];
		$field->setName($name);
		return $field;
	}
}

?>