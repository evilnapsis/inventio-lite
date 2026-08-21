<?php
namespace App\Controller;

use App\Service\ReportService;
use ViewEngine;
use Req;

class ReportController {
	private $reportService;

	public function __construct() {
		$this->reportService = new ReportService();
	}

	public function movements() {
		$sd = Req::get('sd', '');
		$ed = Req::get('ed', '');
		$productId = Req::get('product_id', '');

		$operations = ($sd !== '' && $ed !== '') ? $this->reportService->getMovements($productId, $sd, $ed) : null;

		ViewEngine::render('reports/movements.html.twig', [
			'products' => \ProductData::getAll(),
			'operations' => $operations,
			'sd' => $sd,
			'ed' => $ed,
			'product_id' => $productId,
		]);
	}

	public function sales() {
		$sd = Req::get('sd', '');
		$ed = Req::get('ed', '');
		$clientId = Req::get('client_id', '');

		$sells = null;
		$total = 0;
		if ($sd !== '' && $ed !== '') {
			$sells = $this->reportService->getSalesReport($clientId, $sd, $ed);
			foreach ($sells as $sell) {
				$total += ($sell->total - $sell->discount);
			}
		}

		ViewEngine::render('reports/sales.html.twig', [
			'clients' => \PersonData::getClients(),
			'sells' => $sells,
			'total' => $total,
			'sd' => $sd,
			'ed' => $ed,
			'client_id' => $clientId,
		]);
	}
}
