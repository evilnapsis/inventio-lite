<?php
namespace App\Service;

/**
 * Servicio para la gestión y desvinculación segura de categorías de productos.
 */
class CategoryService {
	public function getAllCategories(): array {
		return \CategoryData::getAll();
	}

	public function getCategoryById($id) {
		return \CategoryData::getById($id);
	}

	public function createCategory(array $data): void {
		$category = new \CategoryData();
		$category->name = $data['name'] ?? '';
		$category->description = $data['description'] ?? '';
		$category->add();
	}

	public function updateCategory($id, array $data): void {
		$category = \CategoryData::getById($id);
		if (!$category) return;
		$category->name = $data['name'] ?? $category->name;
		$category->description = $data['description'] ?? $category->description;
		$category->update();
	}

	// Al eliminar una categoria, los productos asociados quedan sin categoria (misma logica que delcategory-view.php)
	public function deleteCategory($id): void {
		$category = \CategoryData::getById($id);
		if (!$category) return;

		$products = \ProductData::getAllByCategoryId($category->id);
		foreach ($products as $product) {
			$product->del_category();
		}

		$category->del();
	}
}
