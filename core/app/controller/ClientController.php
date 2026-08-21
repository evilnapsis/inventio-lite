<?php
namespace App\Controller;

use App\Service\PersonService;
use ViewEngine;
use Req;

/**
 * Administra el registro y mantenimiento de clientes (kind = 1).
 */
class ClientController {
	private $personService;
	private $baseFolder;

	private $labels = [
		'title' => 'Directorio de Clientes',
		'plural' => 'clients',
		'singular' => 'client',
		'pdf_path' => 'report/clients-pdf.php',
		'new_label' => 'Nuevo Cliente',
		'header_label' => 'CLIENTES',
		'empty_message' => 'No hay clientes',
		'new_title' => 'Nuevo Cliente',
		'new_header' => 'NUEVO CLIENTE',
		'new_button' => 'Agregar Cliente',
		'edit_title' => 'Editar Cliente',
		'edit_header' => 'EDITAR CLIENTE',
		'edit_button' => 'Actualizar Cliente',
	];

	public function __construct() {
		$this->personService = new PersonService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		ViewEngine::render('persons/index.html.twig', $this->labels + ['persons' => $this->personService->getAllClients()]);
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

		$this->personService->createPerson(Req::post(), 1);
		$_SESSION['success'] = 'Cliente agregado correctamente';
		header('Location: ' . $this->baseFolder . '/clients');
	}

	public function edit($vars) {
		$person = $this->personService->getPersonById($vars['id']);
		if (!$person) {
			header('Location: ' . $this->baseFolder . '/clients');
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
		$_SESSION['updated'] = 'Cliente actualizado correctamente';
		header('Location: ' . $this->baseFolder . '/clients');
	}

	public function delete($vars) {
		$this->personService->deletePerson($vars['id']);
		$_SESSION['deleted'] = 'Cliente eliminado correctamente';
		header('Location: ' . $this->baseFolder . '/clients');
	}
}
