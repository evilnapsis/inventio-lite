<?php
namespace App\Service;

/**
 * Compras/Reabastecimiento: mismo modelo `sell`/`operation` que las ventas,
 * distinguido por operation_type_id=1 ("entrada") en vez de 2 ("salida").
 */
class PurchaseService {
	public function getAllPurchases(): array {
		return \SellData::getRes();
	}

	public function getPurchaseById($id) {
		return \SellData::getById($id);
	}

	public function getPurchaseOperations($id): array {
		return \OperationData::getAllProductsBySellId($id);
	}

	// Misma logica que delre-view.php: borra las operaciones y el registro de compra.
	public function deletePurchase($id): void {
		foreach ($this->getPurchaseOperations($id) as $operation) {
			$operation->del();
		}
		$sell = \SellData::getById($id);
		if ($sell) {
			$sell->del();
		}
	}

	/**
	 * Misma logica que processrepos-view.php/processre-view.php (duplicados identicos
	 * en el legacy, aqui unificados): crea el registro de compra y sus operaciones de entrada.
	 * A diferencia de una venta, no se valida stock disponible (restockear no tiene techo).
	 */
	public function checkout(array $cartItems, array $postData, $userId): array {
		if (empty($cartItems)) {
			return ['success' => false, 'sell_id' => null, 'error' => 'La lista de reabastecimiento esta vacia.'];
		}

		$sell = new \SellData();
		$sell->user_id = $userId;

		if (!empty($postData['client_id'])) {
			$sell->person_id = $postData['client_id'];
			$result = $sell->add_re_with_client();
		} else {
			$result = $sell->add_re();
		}
		$sellId = $result[1];

		$entradaId = \OperationTypeData::getByName('entrada')->id;
		foreach ($cartItems as $item) {
			$operation = new \OperationData();
			$operation->product_id = $item['product_id'];
			$operation->operation_type_id = $entradaId;
			$operation->sell_id = $sellId;
			$operation->q = $item['q'];
			$operation->add();
		}

		return ['success' => true, 'sell_id' => $sellId, 'error' => null];
	}
}
