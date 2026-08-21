<?php
namespace App\Controller;

use App\Service\CategoryService;
use ViewEngine;
use Req;

/**
 * Gestiona el catálogo de categorías de productos (listar, crear, editar, eliminar).
 */
class CategoryController {
	private $categoryService;
	private $baseFolder;

	public function __construct() {
		$this->categoryService = new CategoryService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		$categories = $this->categoryService->getAllCategories();
		ViewEngine::render('categories/index.html.twig', ['categories' => $categories]);
	}

	public function new() {
		ViewEngine::render('categories/new.html.twig');
	}

	public function create() {
		$errors = Req::validate(['name' => 'required']);
		if (!empty($errors)) {
			ViewEngine::render('categories/new.html.twig', ['errors' => $errors, 'old' => Req::post()]);
			return;
		}

		$this->categoryService->createCategory(Req::post());
		$_SESSION['success'] = 'Categoria agregada correctamente';
		header('Location: ' . $this->baseFolder . '/categories');
	}

	public function edit($vars) {
		$category = $this->categoryService->getCategoryById($vars['id']);
		if (!$category) {
			header('Location: ' . $this->baseFolder . '/categories');
			return;
		}
		ViewEngine::render('categories/edit.html.twig', ['category' => $category]);
	}

	public function update($vars) {
		$errors = Req::validate(['name' => 'required']);
		if (!empty($errors)) {
			$category = $this->categoryService->getCategoryById($vars['id']);
			ViewEngine::render('categories/edit.html.twig', ['category' => $category, 'errors' => $errors]);
			return;
		}

		$this->categoryService->updateCategory($vars['id'], Req::post());
		$_SESSION['updated'] = 'Categoria actualizada correctamente';
		header('Location: ' . $this->baseFolder . '/categories');
	}

	public function delete($vars) {
		$this->categoryService->deleteCategory($vars['id']);
		$_SESSION['deleted'] = 'Categoria eliminada correctamente';
		header('Location: ' . $this->baseFolder . '/categories');
	}
}
