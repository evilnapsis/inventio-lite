<?php
namespace App\Controller;

use App\Service\BoxService;
use ViewEngine;

/**
 * Controla el flujo de caja diario, cierres de caja e historial de cortes.
 */
class BoxController {
	private $boxService;
	private $baseFolder;

	public function __construct() {
		$this->boxService = new BoxService();
		$this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	}

	public function index() {
		$data = $this->boxService->getSellRows($this->boxService->getUnboxedSells());
		ViewEngine::render('box/index.html.twig', $data);
	}

	public function history() {
		$boxes = $this->boxService->getAllBoxes();
		$rows = [];
		foreach ($boxes as $box) {
			$sells = $this->boxService->getBoxSells($box->id);
			$rows[] = ['box' => $box, 'total' => $this->boxService->getSellsTotal($sells)];
		}
		ViewEngine::render('box/history.html.twig', ['rows' => $rows]);
	}

	public function show($vars) {
		$box = $this->boxService->getBoxById($vars['id']);
		$data = $this->boxService->getSellRows($this->boxService->getBoxSells($vars['id']));
		ViewEngine::render('box/show.html.twig', [
			'box' => $box,
			'box_id' => $vars['id'],
			'rows' => $data['rows'],
			'total' => $data['total'],
		]);
	}

	public function process() {
		$boxId = $this->boxService->processBox();
		if ($boxId) {
			header('Location: ' . $this->baseFolder . '/box/' . $boxId);
		} else {
			header('Location: ' . $this->baseFolder . '/box');
		}
	}
}
