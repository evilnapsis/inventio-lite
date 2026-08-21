<?php
namespace App\Controller;

use App\Service\ConfigurationService;
use ViewEngine;
use Req;

class SettingsController {
	private $configService;
	private $baseFolder;

	public function __construct() {
		$this->configService = new ConfigurationService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		$configs = $this->configService->getAll();
		ViewEngine::render('settings/index.html.twig', [
			'configs' => $configs
		]);
	}

	public function update() {
		$configs = Req::post('configs', []);
		if (is_array($configs)) {
			$this->configService->updateAll($configs);
			$_SESSION['updated'] = 'Ajustes actualizados correctamente.';
		}
		header('Location: ' . $this->baseFolder . '/settings');
	}
}
