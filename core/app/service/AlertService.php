<?php
namespace App\Service;

/**
 * Servicio para evaluar el nivel de inventario y calcular alertas de stock bajo.
 */
class AlertService {
	// Productos en o por debajo de su minimo de inventario, con el mismo criterio de severidad
	// que alerts-view.php (0 = sin existencias, <=min/2 = muy pocas, <=min = pocas).
	public function getLowStockRows(): array {
		$rows = [];
		foreach (\ProductData::getAll() as $product) {
			$q = \OperationData::getQYesF($product->id);
			if ($q > $product->inventary_min) continue;

			if ($q == 0) {
				$severity = 'none';
			} elseif ($q <= $product->inventary_min / 2) {
				$severity = 'critical';
			} else {
				$severity = 'low';
			}

			$rows[] = ['product' => $product, 'q' => $q, 'severity' => $severity];
		}
		return $rows;
	}
}
