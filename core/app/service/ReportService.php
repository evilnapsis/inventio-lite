<?php
namespace App\Service;

/**
 * Servicio para procesar datos de reportes de kardex/movimientos y ventas por rango.
 */
class ReportService {
	public function getMovements($productId, $start, $end): array {
		if (empty($productId)) {
			return \OperationData::getAllByDateOfficial($start, $end);
		}
		return \OperationData::getAllByDateOfficialBP($productId, $start, $end);
	}

	public function getSalesReport($clientId, $start, $end): array {
		if (empty($clientId)) {
			return \SellData::getAllByDateOp($start, $end, 2);
		}
		return \SellData::getAllByDateBCOp($clientId, $start, $end, 2);
	}
}
