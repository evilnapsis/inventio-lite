<?php
namespace App\Controller;

use App\Service\PurchaseService;
use ViewEngine;

/**
 * Consulta y gestión del historial de compras/reabastecimientos.
 */
class PurchaseController {
	private $purchaseService;
	private $baseFolder;

	public function __construct() {
		$this->purchaseService = new PurchaseService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		$purchases = $this->purchaseService->getAllPurchases();
		$rows = [];
		foreach ($purchases as $sell) {
			$operations = $this->purchaseService->getPurchaseOperations($sell->id);
			$total = 0;
			foreach ($operations as $operation) {
				$total += $operation->q * $operation->getProduct()->price_in;
			}
			$rows[] = ['sell' => $sell, 'count' => count($operations), 'total' => $total];
		}
		ViewEngine::render('purchases/index.html.twig', ['rows' => $rows]);
	}

	public function show($vars) {
		$sell = $this->purchaseService->getPurchaseById($vars['id']);
		if (!$sell) {
			ViewEngine::render('purchases/show.html.twig', ['sell' => null]);
			return;
		}

		$operations = $this->purchaseService->getPurchaseOperations($vars['id']);
		$total = 0;
		$lines = [];
		foreach ($operations as $operation) {
			$product = $operation->getProduct();
			$subtotal = $operation->q * $product->price_in;
			$total += $subtotal;
			$lines[] = ['operation' => $operation, 'product' => $product, 'subtotal' => $subtotal];
		}

		ViewEngine::render('purchases/show.html.twig', [
			'sell' => $sell,
			'lines' => $lines,
			'total' => $total,
			'provider' => $sell->person_id != '' ? $sell->getPerson() : null,
			'user' => $sell->user_id != '' ? $sell->getUser() : null,
		]);
	}

	public function delete($vars) {
		$this->purchaseService->deletePurchase($vars['id']);
		header('Location: ' . $this->baseFolder . '/purchases');
	}
}
