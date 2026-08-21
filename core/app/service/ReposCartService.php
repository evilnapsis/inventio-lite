<?php
namespace App\Service;

/**
 * Maneja $_SESSION['reabastecer'] -- el carrito de Compras/Reabastecimiento,
 * independiente del carrito de Ventas ($_SESSION['cart'], ver CartService).
 * A diferencia de las ventas, aqui no se limita la cantidad al stock actual
 * (restockear no tiene techo) -- mismo comportamiento que addtorepos-action.php.
 */
class ReposCartService {
	public function getCart(): array {
		return array_values($_SESSION['reabastecer'] ?? []);
	}

	public function addItem($productId, $qty): void {
		$cart = $this->getCart();
		$index = null;

		foreach ($cart as $i => $item) {
			if ($item['product_id'] == $productId) {
				$index = $i;
				break;
			}
		}

		if ($index !== null) {
			$cart[$index]['q'] += $qty;
		} else {
			$cart[] = ['product_id' => $productId, 'q' => $qty];
		}

		$_SESSION['reabastecer'] = $cart;
	}

	public function removeItem($productId): void {
		$cart = array_values(array_filter($this->getCart(), function($item) use ($productId) {
			return $item['product_id'] != $productId;
		}));
		$_SESSION['reabastecer'] = $cart;
	}

	public function clear(): void {
		unset($_SESSION['reabastecer']);
	}

	// Precio de compra (price_in), a diferencia del carrito de ventas que usa price_out.
	public function getItemsWithProducts(): array {
		$items = [];
		foreach ($this->getCart() as $item) {
			$product = \ProductData::getById($item['product_id']);
			if (!$product) continue;
			$items[] = [
				'product' => $product,
				'q' => $item['q'],
				'subtotal' => $product->price_in * $item['q'],
			];
		}
		return $items;
	}

	public function getTotal(): float {
		$total = 0;
		foreach ($this->getItemsWithProducts() as $item) {
			$total += $item['subtotal'];
		}
		return $total;
	}
}
