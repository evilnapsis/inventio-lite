<?php
namespace App\Controller;

use App\Service\InventoryService;
use ViewEngine;

/**
 * Maneja la vista del resumen general de existencias e inventario.
 */
class InventoryController {
	private $inventoryService;

	public function __construct() {
		$this->inventoryService = new InventoryService();
	}

	public function index() {
		ViewEngine::render('inventory/index.html.twig', $this->inventoryService->getInventorySummary());
	}
}
