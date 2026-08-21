<?php
namespace App\Controller;

use App\Service\SellService;
use ViewEngine;

class SellController {
	private $sellService;
	private $baseFolder;

	public function __construct() {
		$this->sellService = new SellService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		$sells = $this->sellService->getAllSells();

		$totalGross = 0;
		$totalDiscount = 0;
		$rows = [];
		foreach ($sells as $sell) {
			$totalGross += $sell->total;
			$totalDiscount += $sell->discount;

			$client = $sell->person_id != '' ? $sell->getPerson() : null;
			$user = $sell->user_id != '' ? $sell->getUser() : null;
			$operations = $this->sellService->getSellOperations($sell->id);
			$itemsCount = 0;
			foreach ($operations as $op) { $itemsCount += $op->q; }

			$rows[] = [
				'sell' => $sell,
				'client_name' => $client ? $client->name . ' ' . $client->lastname : 'Público General',
				'user_name' => $user ? $user->name . ' ' . $user->lastname : 'Sistema',
				'refs' => count($operations),
				'items_count' => $itemsCount,
			];
		}

		ViewEngine::render('sells/index.html.twig', [
			'rows' => $rows,
			'total_transactions' => count($sells),
			'total_gross' => $totalGross,
			'total_discount' => $totalDiscount,
			'total_net' => $totalGross - $totalDiscount,
		]);
	}

	public function show($vars) {
		$sell = $this->sellService->getSellById($vars['id']);
		if (!$sell) {
			ViewEngine::render('sells/show.html.twig', ['sell' => null]);
			return;
		}

		$operations = $this->sellService->getSellOperations($vars['id']);
		$total = 0;
		$lines = [];
		foreach ($operations as $operation) {
			$product = $operation->getProduct();
			$subtotal = $operation->q * $product->price_out;
			$total += $subtotal;
			$lines[] = ['operation' => $operation, 'product' => $product, 'subtotal' => $subtotal];
		}

		ViewEngine::render('sells/show.html.twig', [
			'sell' => $sell,
			'lines' => $lines,
			'total' => $total,
			'client' => $sell->person_id != '' ? $sell->getPerson() : null,
			'user' => $sell->user_id != '' ? $sell->getUser() : null,
		]);
	}

	public function delete($vars) {
		$this->sellService->deleteSell($vars['id']);
		header('Location: ' . $this->baseFolder . '/sells');
	}
}
