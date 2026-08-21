<?php
namespace App\Controller;

use App\Service\AlertService;
use ViewEngine;

class AlertController {
	private $alertService;

	public function __construct() {
		$this->alertService = new AlertService();
	}

	public function index() {
		ViewEngine::render('alerts/index.html.twig', ['rows' => $this->alertService->getLowStockRows()]);
	}
}
