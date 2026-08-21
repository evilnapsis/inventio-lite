<?php
namespace App\Controller;

use App\Service\ReposCartService;
use App\Service\PurchaseService;
use ViewEngine;
use Req;

class ReposController {
	private $cartService;
	private $purchaseService;
	private $baseFolder;

	public function __construct() {
		$this->cartService = new ReposCartService();
		$this->purchaseService = new PurchaseService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		// Soporta el link "Comprar" de Inventario (./repos?product=Nombre) precargando la busqueda.
		ViewEngine::render('repos/index.html.twig', ['preload_product' => Req::get('product', '')]);
	}

	public function search() {
		$term = Req::get('product', '');
		$products = $term !== '' ? \ProductData::getLike($term) : [];

		$rows = [];
		foreach ($products as $product) {
			$rows[] = ['product' => $product, 'q' => \OperationData::getQYesF($product->id)];
		}

		ViewEngine::render('repos/_search.html.twig', ['rows' => $rows, 'term' => $term]);
	}

	public function cartSummary() {
		ViewEngine::render('repos/_cart.html.twig', [
			'items' => $this->cartService->getItemsWithProducts(),
			'total' => $this->cartService->getTotal(),
			'providers' => \PersonData::getProviders(),
		]);
	}

	public function addToCart() {
		$this->cartService->addItem(Req::post('product_id'), (float)Req::post('q'));
		echo 'success';
	}

	public function removeFromCart() {
		$this->cartService->removeItem(Req::post('product_id'));
	}

	public function clearCart() {
		$this->cartService->clear();
		header('Location: ' . $this->baseFolder . '/repos');
	}

	public function checkout() {
		$result = $this->purchaseService->checkout($this->cartService->getCart(), Req::post(), $_SESSION['user_id']);

		if (!$result['success']) {
			$_SESSION['error'] = $result['error'];
			header('Location: ' . $this->baseFolder . '/repos');
			return;
		}

		$this->cartService->clear();
		$_SESSION['success'] = 'Compra (Reposición) procesada correctamente';
		header('Location: ' . $this->baseFolder . '/purchase/' . $result['sell_id']);
	}
}
