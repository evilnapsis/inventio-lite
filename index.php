<?php
/**
* @author evilnapsis
**/

define("ROOT", dirname(__FILE__));

$debug= true;
if($debug){
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
}

include "core/autoload.php";
include_once "core/app/autoload.php";

ob_start();
session_start();
Core::$root="";

// si quieres que se muestre las consultas SQL debes decomentar la siguiente linea
// Core::$debug_sql = true;

// --- Front controller nuevo (FastRoute) para los modulos ya migrados ---
// Si la URI no matchea ninguna ruta limpia, se cae al ruteo legacy (?view=/?action=) de siempre.
use App\Service\AuthService;

$routes = require __DIR__ . '/core/app/routes.php';
$dispatcher = FastRoute\simpleDispatcher($routes);

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
if (false !== $pos = strpos($uri, '?')) {
	$uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if (!empty($baseFolder) && strpos($uri, $baseFolder) === 0) {
	$uri = substr($uri, strlen($baseFolder));
}
if (empty($uri)) {
	$uri = '/';
}

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

if ($routeInfo[0] === FastRoute\Dispatcher::FOUND) {
	if ($httpMethod === 'POST') {
		$token = $_POST['csrf_token'] ?? null;
		if (!Session::validateCsrf($token)) {
			http_response_code(403);
			echo "<h1>403 - Token CSRF invalido</h1><p>Recarga el formulario e intenta de nuevo.</p>";
			exit;
		}
	}

	// Controladores que requieren sesion iniciada (se amplia con cada modulo migrado)
	$protectedControllers = [
		App\Controller\HomeController::class,
		App\Controller\CategoryController::class,
		App\Controller\ProductController::class,
		App\Controller\ClientController::class,
		App\Controller\ProviderController::class,
		App\Controller\UserController::class,
		App\Controller\InventoryController::class,
		App\Controller\SellController::class,
		App\Controller\PosController::class,
		App\Controller\BoxController::class,
		App\Controller\ReposController::class,
		App\Controller\PurchaseController::class,
		App\Controller\ReportController::class,
		App\Controller\AlertController::class,
		App\Controller\SettingsController::class,
		App\Controller\ProfileController::class,
	];
	$handler = $routeInfo[1];
	if (in_array($handler[0], $protectedControllers, true) && !AuthService::check()) {
		header('Location: ' . $baseFolder . '/?view=login');
		exit;
	}

	[$controllerClass, $method] = $handler;
	$controller = new $controllerClass();
	$controller->$method($routeInfo[2]);
	exit;
}

// Ruta no encontrada (404)
http_response_code(404);
echo "<h1>404 - Página no encontrada</h1>";
exit;

?>
