<?php
namespace App\Service;

/**
 * Verifica la sesion iniciada por el flujo de login legacy
 * (processlogin-action.php ya escribe $_SESSION['user_id']).
 */
class AuthService {
	public static function check(): bool {
		return isset($_SESSION['user_id']);
	}
}
