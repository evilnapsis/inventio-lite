<?php
namespace App\Controller;

use App\Service\AlertService;
use ViewEngine;

/**
 * Muestra las alertas de productos con stock bajo o agotado.
 */
class AlertController {
	private $alertService;

	public function __construct() {
		$this->alertService = new AlertService();
	}

	public function index() {
		ViewEngine::render('alerts/index.html.twig', ['rows' => $this->alertService->getLowStockRows()]);
	}
}
