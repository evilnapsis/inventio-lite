<?php
namespace App\Service;

/**
 * Gestiona el ciclo de vida del producto y sus entradas/existencias iniciales.
 */
class ProductService {
	public function getAllProducts(): array {
		return \ProductData::getAll();
	}

	public function getProductById($id) {
		return \ProductData::getById($id);
	}

	public function createProduct(array $data, ?string $imageFilename, $userId): \ProductData {
		$product = new \ProductData();
		$product->barcode = $data['barcode'] ?? '';
		$product->name = $data['name'] ?? '';
		$product->description = $data['description'] ?? '';
		$product->price_in = $data['price_in'] ?? 0;
		$product->price_out = $data['price_out'] ?? 0;
		$product->unit = $data['unit'] ?? '';
		$product->presentation = $data['presentation'] ?? '';
		$product->category_id = !empty($data['category_id']) ? $data['category_id'] : null;
		$product->inventary_min = ($data['inventary_min'] ?? '') !== '' ? $data['inventary_min'] : 10;
		$product->user_id = $userId;

		if ($imageFilename !== null) {
			$product->image = $imageFilename;
			$product->add_with_image();
		} else {
			$product->add();
		}

		$initialStock = (float)($data['q'] ?? 0);
		if ($initialStock > 0) {
			$operation = new \OperationData();
			$operation->product_id = $product->id;
			$operation->operation_type_id = \OperationTypeData::getByName('entrada')->id;
			$operation->q = $initialStock;
			$operation->sell_id = 'NULL';
			$operation->add();
		}

		return $product;
	}

	public function updateProduct($id, array $data, ?string $imageFilename): void {
		$product = \ProductData::getById($id);
		if (!$product) return;

		$product->barcode = $data['barcode'] ?? $product->barcode;
		$product->name = $data['name'] ?? $product->name;
		$product->description = $data['description'] ?? $product->description;
		$product->price_in = $data['price_in'] ?? $product->price_in;
		$product->price_out = $data['price_out'] ?? $product->price_out;
		$product->unit = $data['unit'] ?? $product->unit;
		$product->presentation = $data['presentation'] ?? $product->presentation;
		$product->category_id = !empty($data['category_id']) ? $data['category_id'] : null;
		$product->inventary_min = ($data['inventary_min'] ?? '') !== '' ? $data['inventary_min'] : 10;
		$product->is_active = !empty($data['is_active']) ? 1 : 0;
		$product->update();

		if ($imageFilename !== null) {
			$product->image = $imageFilename;
			$product->update_image();
		}
	}

	// Elimina tambien las operaciones de inventario asociadas (misma logica que delproduct-view.php)
	public function deleteProduct($id): void {
		$operations = \OperationData::getAllByProductId($id);
		foreach ($operations as $operation) {
			$operation->del();
		}

		$product = \ProductData::getById($id);
		if ($product) {
			$product->del();
		}
	}
}
