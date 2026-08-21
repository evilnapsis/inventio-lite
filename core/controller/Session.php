<?php

/**
* 1 de agosto del 2013
* Esta funcion contiene el nombre de los identificadores que se usaran como variables de session
* y tambien los setters y getters correspondientes.
**/

class Session{
	public static function setUID($uid){
		$_SESSION['user_id'] = $uid;
	}

	public static function unsetUID(){
		if(isset($_SESSION['user_id']))
			unset($_SESSION['user_id']);
	}

	public static function issetUID(){
		if(isset($_SESSION['user_id']))
			return true;
		else return false;
	}

	public static function getUID(){
		if(isset($_SESSION['user_id']))
			return $_SESSION['user_id'];
		else return false;
	}

	// Anadido para la migracion a rutas limpias (FastRoute) / proteccion CSRF
	public static function csrfToken(): string {
		if(empty($_SESSION['csrf_token'])){
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		}
		return $_SESSION['csrf_token'];
	}

	public static function validateCsrf(?string $token): bool {
		if(empty($_SESSION['csrf_token']) || empty($token)){
			return false;
		}
		return hash_equals($_SESSION['csrf_token'], $token);
	}

}

?>