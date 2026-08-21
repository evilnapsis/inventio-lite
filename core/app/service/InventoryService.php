<?php
namespace App\Service;

class InventoryService {
	public function getInventorySummary(): array {
		$products = \ProductData::getAll();
		$totalItems = 0;
		$lowStockCount = 0;
		$inventoryValue = 0;
		$rows = [];

		foreach ($products as $product) {
			$q = \OperationData::getQYesF($product->id);
			$totalItems += $q;
			if ($q <= $product->inventary_min) {
				$lowStockCount++;
			}
			$inventoryValue += ($q * $product->price_in);

			if ($q == 0) {
				$status = 'out';
			} elseif ($q <= $product->inventary_min) {
				$status = 'low';
			} else {
				$status = 'ok';
			}

			$rows[] = ['product' => $product, 'q' => $q, 'status' => $status];
		}

		return [
			'rows' => $rows,
			'total_products' => count($products),
			'total_items' => $totalItems,
			'low_stock_count' => $lowStockCount,
			'inventory_value' => $inventoryValue,
		];
	}
}
