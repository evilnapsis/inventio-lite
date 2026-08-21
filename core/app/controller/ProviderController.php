<?php
namespace App\Controller;

use App\Service\PersonService;
use ViewEngine;
use Req;

class ProviderController {
	private $personService;
	private $baseFolder;

	private $labels = [
		'title' => 'Directorio de Proveedores',
		'plural' => 'providers',
		'singular' => 'provider',
		'pdf_path' => 'report/providers-pdf.php',
		'new_label' => 'Nuevo Proveedor',
		'header_label' => 'PROVEEDORES',
		'empty_message' => 'No hay proveedores',
		'new_title' => 'Nuevo Proveedor',
		'new_header' => 'NUEVO PROVEEDOR',
		'new_button' => 'Agregar Proveedor',
		'edit_title' => 'Editar Proveedor',
		'edit_header' => 'EDITAR PROVEEDOR',
		'edit_button' => 'Actualizar Proveedor',
	];

	public function __construct() {
		$this->personService = new PersonService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		ViewEngine::render('persons/index.html.twig', $this->labels + ['persons' => $this->personService->getAllProviders()]);
	}

	public function new() {
		ViewEngine::render('persons/new.html.twig', $this->labels);
	}

	public function create() {
		$errors = Req::validate(['lastname' => 'required', 'address1' => 'required']);
		if (!empty($errors)) {
			ViewEngine::render('persons/new.html.twig', $this->labels + ['errors' => $errors, 'old' => Req::post()]);
			return;
		}

		$this->personService->createPerson(Req::post(), 2);
		$_SESSION['success'] = 'Proveedor agregado correctamente';
		header('Location: ' . $this->baseFolder . '/providers');
	}

	public function edit($vars) {
		$person = $this->personService->getPersonById($vars['id']);
		if (!$person) {
			header('Location: ' . $this->baseFolder . '/providers');
			return;
		}
		ViewEngine::render('persons/edit.html.twig', $this->labels + ['person' => $person]);
	}

	public function update($vars) {
		$errors = Req::validate(['lastname' => 'required', 'address1' => 'required']);
		if (!empty($errors)) {
			ViewEngine::render('persons/edit.html.twig', $this->labels + [
				'person' => $this->personService->getPersonById($vars['id']),
				'errors' => $errors,
			]);
			return;
		}

		$this->personService->updatePerson($vars['id'], Req::post());
		$_SESSION['updated'] = 'Proveedor actualizado correctamente';
		header('Location: ' . $this->baseFolder . '/providers');
	}

	public function delete($vars) {
		$this->personService->deletePerson($vars['id']);
		$_SESSION['deleted'] = 'Proveedor eliminado correctamente';
		header('Location: ' . $this->baseFolder . '/providers');
	}
}
