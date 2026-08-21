<?php
namespace App\Service;

class BoxService {
	public function getUnboxedSells(): array {
		return \SellData::getSellsUnBoxed();
	}

	public function getAllBoxes(): array {
		return \BoxData::getAll();
	}

	public function getBoxById($id) {
		return \BoxData::getById($id);
	}

	public function getBoxSells($boxId): array {
		return \SellData::getByBoxId($boxId);
	}

	// Una fila por venta con su cantidad de productos y total, mas la suma global (box-view.php/b-view.php).
	public function getSellRows(array $sells): array {
		$rows = [];
		$total = 0;
		foreach ($sells as $sell) {
			$operations = \OperationData::getAllProductsBySellId($sell->id);
			$sellTotal = 0;
			foreach ($operations as $operation) {
				$sellTotal += $operation->q * $operation->getProduct()->price_out;
			}
			$total += $sellTotal;
			$rows[] = ['sell' => $sell, 'count' => count($operations), 'total' => $sellTotal];
		}
		return ['rows' => $rows, 'total' => $total];
	}

	// Total vendido de un conjunto de ventas, sumando sus operaciones (misma logica que boxhistory-view.php).
	public function getSellsTotal(array $sells): float {
		return $this->getSellRows($sells)['total'];
	}

	// Misma logica que processbox-view.php: agrupa todas las ventas sin caja en un nuevo corte.
	public function processBox() {
		$sells = $this->getUnboxedSells();
		if (empty($sells)) {
			return null;
		}

		$box = new \BoxData();
		$result = $box->add();
		$boxId = $result[1];

		foreach ($sells as $sell) {
			$sell->box_id = $boxId;
			$sell->update_box();
		}

		return $boxId;
	}
}
