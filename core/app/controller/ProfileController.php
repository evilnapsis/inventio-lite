<?php
namespace App\Controller;

use App\Service\SettingsService;
use ViewEngine;
use Req;

class ProfileController {
	private $settingsService;
	private $baseFolder;

	public function __construct() {
		$this->settingsService = new SettingsService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		ViewEngine::render('profile/index.html.twig');
	}

	public function changePassword() {
		$result = $this->settingsService->changePassword(
			$_SESSION['user_id'],
			Req::post('password', ''),
			Req::post('newpassword', ''),
			Req::post('confirmnewpassword', '')
		);

		if (!$result['success']) {
			$_SESSION['error'] = $result['error'];
			header('Location: ' . $this->baseFolder . '/profile');
			return;
		}

		header('Location: ' . $this->baseFolder . '/logout.php');
	}
}
