<?php
namespace App\Controller;

use App\Service\UserService;
use ViewEngine;
use Req;

class UserController {
	private $userService;
	private $baseFolder;

	public function __construct() {
		$this->userService = new UserService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		ViewEngine::render('users/index.html.twig', ['users' => $this->userService->getAllUsers()]);
	}

	public function new() {
		ViewEngine::render('users/new.html.twig');
	}

	public function create() {
		$errors = Req::validate(['lastname' => 'required', 'username' => 'required']);
		if (!empty($errors)) {
			ViewEngine::render('users/new.html.twig', ['errors' => $errors, 'old' => Req::post()]);
			return;
		}

		$this->userService->createUser(Req::post());
		$_SESSION['success'] = 'Usuario agregado correctamente';
		header('Location: ' . $this->baseFolder . '/users');
	}

	public function edit($vars) {
		$user = $this->userService->getUserById($vars['id']);
		if (!$user) {
			header('Location: ' . $this->baseFolder . '/users');
			return;
		}
		ViewEngine::render('users/edit.html.twig', ['user' => $user]);
	}

	public function update($vars) {
		$errors = Req::validate(['lastname' => 'required', 'username' => 'required']);
		if (!empty($errors)) {
			ViewEngine::render('users/edit.html.twig', [
				'user' => $this->userService->getUserById($vars['id']),
				'errors' => $errors,
			]);
			return;
		}

		$this->userService->updateUser($vars['id'], Req::post());
		$_SESSION['updated'] = 'Usuario actualizado correctamente';
		header('Location: ' . $this->baseFolder . '/users');
	}

	public function delete($vars) {
		if ($this->userService->deleteUser($vars['id'], $_SESSION['user_id'] ?? null)) {
			$_SESSION['deleted'] = 'Usuario eliminado correctamente';
		}
		header('Location: ' . $this->baseFolder . '/users');
	}
}
