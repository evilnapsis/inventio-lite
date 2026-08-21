<?php
namespace App\Controller;

use App\Service\AuthService;
use ViewEngine;
use Req;

/**
 * Controla el inicio y cierre de sesión de usuarios.
 */
class AuthController {
	private $baseFolder;

	public function __construct() {
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function showLogin() {
		if (AuthService::check()) {
			header('Location: ' . $this->baseFolder . '/home');
			exit;
		}
		ViewEngine::render('auth/login.html.twig');
	}

	public function processLogin() {
		$username = Req::post('username', '');
		$password = Req::post('password', '');
		$hashedPassword = sha1(md5($password));

		$user = null;
		$allUsers = \UserData::getAll();
		foreach ($allUsers as $u) {
			if (($u->username === $username || $u->email === $username) && $u->password === $hashedPassword) {
				$user = $u;
				break;
			}
		}

		if ($user) {
			if (!$user->is_active) {
				ViewEngine::render('auth/login.html.twig', ['error' => 'Usuario inactivo.']);
				return;
			}
			$_SESSION['user_id'] = $user->id;
			header('Location: ' . $this->baseFolder . '/home');
			exit;
		}

		ViewEngine::render('auth/login.html.twig', ['error' => 'Usuario o contraseña incorrectos.']);
	}

	public function logout() {
		if (isset($_SESSION['user_id'])) {
			unset($_SESSION['user_id']);
		}
		session_destroy();
		header('Location: ' . $this->baseFolder . '/login');
		exit;
	}
}
