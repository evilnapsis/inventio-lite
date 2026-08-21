<?php
namespace App\Controller;

use App\Service\ProductService;
use ViewEngine;
use Req;
use Upload;

/**
 * Gestiona el catálogo de productos, su historial de movimientos y la carga de imágenes.
 */
class ProductController {
	private $productService;
	private $baseFolder;

	public function __construct() {
		$this->productService = new ProductService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		$products = $this->productService->getAllProducts();
		ViewEngine::render('products/index.html.twig', ['products' => $products]);
	}

	public function new() {
		$categories = \CategoryData::getAll();
		ViewEngine::render('products/new.html.twig', ['categories' => $categories]);
	}

	public function create() {
		$errors = Req::validate(['name' => 'required', 'barcode' => 'required']);
		if (!empty($errors)) {
			ViewEngine::render('products/new.html.twig', [
				'categories' => \CategoryData::getAll(),
				'errors' => $errors,
				'old' => Req::post(),
			]);
			return;
		}

		$this->productService->createProduct(Req::post(), $this->handleImageUpload(), $_SESSION['user_id']);
		$_SESSION['success'] = 'Producto agregado correctamente';
		header('Location: ' . $this->baseFolder . '/products');
	}

	public function edit($vars) {
		$product = $this->productService->getProductById($vars['id']);
		if (!$product) {
			header('Location: ' . $this->baseFolder . '/products');
			return;
		}
		ViewEngine::render('products/edit.html.twig', [
			'product' => $product,
			'categories' => \CategoryData::getAll(),
		]);
	}

	public function update($vars) {
		$errors = Req::validate(['name' => 'required', 'barcode' => 'required']);
		if (!empty($errors)) {
			ViewEngine::render('products/edit.html.twig', [
				'product' => $this->productService->getProductById($vars['id']),
				'categories' => \CategoryData::getAll(),
				'errors' => $errors,
			]);
			return;
		}

		$this->productService->updateProduct($vars['id'], Req::post(), $this->handleImageUpload());
		$_SESSION['updated'] = 'Producto actualizado correctamente';
		header('Location: ' . $this->baseFolder . '/products');
	}

	public function delete($vars) {
		$this->productService->deleteProduct($vars['id']);
		$_SESSION['deleted'] = 'Producto eliminado correctamente';
		header('Location: ' . $this->baseFolder . '/products');
	}

	public function history($vars) {
		$product = $this->productService->getProductById($vars['id']);
		if (!$product) {
			header('Location: ' . $this->baseFolder . '/products');
			return;
		}

		ViewEngine::render('products/history.html.twig', [
			'product' => $product,
			'operations' => \OperationData::getAllByProductId($product->id),
			'input_total' => \OperationData::getInputQYesF($product->id),
			'available_total' => \OperationData::getQYesF($product->id),
			'output_total' => -1 * \OperationData::getOutputQYesF($product->id),
		]);
	}

	public function deleteOperation($vars) {
		$operation = \OperationData::getById($vars['opid']);
		if ($operation) {
			$operation->del();
		}
		header('Location: ' . $this->baseFolder . '/product/' . $vars['id'] . '/history');
	}

	private function handleImageUpload(): ?string {
		if (empty($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
			return null;
		}

		$image = new Upload($_FILES['image']);
		if (!$image->uploaded) {
			return null;
		}

		$image->Process('storage/products/');
		return $image->processed ? $image->file_dst_name : null;
	}
}
