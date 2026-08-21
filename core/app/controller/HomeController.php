<?php
namespace App\Controller;

use App\Service\HomeService;
use ViewEngine;

/**
 * Controla la vista principal (Dashboard) del sistema.
 */
class HomeController {
	private $homeService;

	public function __construct() {
		$this->homeService = new HomeService();
	}

	public function index() {
		ViewEngine::render('home/index.html.twig', $this->homeService->getDashboardData());
	}
}
