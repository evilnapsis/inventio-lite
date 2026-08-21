<?php
namespace App\Controller;

use App\Service\CartService;
use App\Service\SellService;
use ViewEngine;
use Req;

class PosController {
	private $cartService;
	private $sellService;
	private $baseFolder;

	public function __construct() {
		$this->cartService = new CartService();
		$this->sellService = new SellService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		ViewEngine::render('pos/index.html.twig');
	}

	public function search() {
		$term = Req::get('product', '');
		$products = $term !== '' ? \ProductData::getLike($term) : [];

		$rows = [];
		$omitted = 0;
		foreach ($products as $product) {
			$q = \OperationData::getQYesF($product->id);
			if ($q > 0) {
				$rows[] = ['product' => $product, 'q' => $q];
			} else {
				$omitted++;
			}
		}

		ViewEngine::render('pos/_search.html.twig', ['rows' => $rows, 'omitted' => $omitted, 'term' => $term]);
	}

	public function cartSummary() {
		ViewEngine::render('pos/_cart.html.twig', [
			'items' => $this->cartService->getItemsWithProducts(),
			'total' => $this->cartService->getTotal(),
			'clients' => \PersonData::getClients(),
		]);
	}

	public function addToCart() {
		$ok = $this->cartService->addItem(Req::post('product_id'), (float)Req::post('q'));
		echo $ok ? 'success' : 'error_insufficient_stock';
	}

	public function removeFromCart() {
		$this->cartService->removeItem(Req::post('product_id'));
	}

	public function clearCart() {
		$this->cartService->clear();
		header('Location: ' . $this->baseFolder . '/pos');
	}

	public function checkout() {
		$result = $this->sellService->checkout($this->cartService->getCart(), Req::post(), $_SESSION['user_id']);

		if (!$result['success']) {
			$_SESSION['error'] = $result['error'];
			header('Location: ' . $this->baseFolder . '/pos');
			return;
		}

		$this->cartService->clear();
		$_SESSION['success'] = 'Venta POS procesada correctamente';
		header('Location: ' . $this->baseFolder . '/sell/' . $result['sell_id']);
	}
}
