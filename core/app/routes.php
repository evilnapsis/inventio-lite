<?php
use App\Controller\HomeController;
use App\Controller\CategoryController;
use App\Controller\ProductController;
use App\Controller\ClientController;
use App\Controller\ProviderController;
use App\Controller\UserController;
use App\Controller\InventoryController;
use App\Controller\SellController;
use App\Controller\PosController;
use App\Controller\BoxController;
use App\Controller\ReposController;
use App\Controller\PurchaseController;
use App\Controller\ReportController;
use App\Controller\AlertController;
use App\Controller\SettingsController;
use App\Controller\ProfileController;
use App\Controller\AuthController;

return function(FastRoute\RouteCollector $r) {
	$r->addRoute('GET', '/', [HomeController::class, 'index']);
	$r->addRoute('GET', '/home', [HomeController::class, 'index']);

	$r->addRoute('GET', '/login', [AuthController::class, 'showLogin']);
	$r->addRoute('POST', '/login', [AuthController::class, 'processLogin']);
	$r->addRoute('GET', '/logout', [AuthController::class, 'logout']);

	$r->addRoute('GET', '/categories', [CategoryController::class, 'index']);
	$r->addRoute('GET', '/category/new', [CategoryController::class, 'new']);
	$r->addRoute('POST', '/category/create', [CategoryController::class, 'create']);
	$r->addRoute('GET', '/category/{id:\d+}/edit', [CategoryController::class, 'edit']);
	$r->addRoute('POST', '/category/{id:\d+}/update', [CategoryController::class, 'update']);
	$r->addRoute('POST', '/category/{id:\d+}/delete', [CategoryController::class, 'delete']);

	$r->addRoute('GET', '/products', [ProductController::class, 'index']);
	$r->addRoute('GET', '/product/new', [ProductController::class, 'new']);
	$r->addRoute('POST', '/product/create', [ProductController::class, 'create']);
	$r->addRoute('GET', '/product/{id:\d+}/edit', [ProductController::class, 'edit']);
	$r->addRoute('POST', '/product/{id:\d+}/update', [ProductController::class, 'update']);
	$r->addRoute('POST', '/product/{id:\d+}/delete', [ProductController::class, 'delete']);
	$r->addRoute('GET', '/product/{id:\d+}/history', [ProductController::class, 'history']);
	$r->addRoute('POST', '/product/{id:\d+}/operation/{opid:\d+}/delete', [ProductController::class, 'deleteOperation']);

	$r->addRoute('GET', '/clients', [ClientController::class, 'index']);
	$r->addRoute('GET', '/client/new', [ClientController::class, 'new']);
	$r->addRoute('POST', '/client/create', [ClientController::class, 'create']);
	$r->addRoute('GET', '/client/{id:\d+}/edit', [ClientController::class, 'edit']);
	$r->addRoute('POST', '/client/{id:\d+}/update', [ClientController::class, 'update']);
	$r->addRoute('POST', '/client/{id:\d+}/delete', [ClientController::class, 'delete']);

	$r->addRoute('GET', '/providers', [ProviderController::class, 'index']);
	$r->addRoute('GET', '/provider/new', [ProviderController::class, 'new']);
	$r->addRoute('POST', '/provider/create', [ProviderController::class, 'create']);
	$r->addRoute('GET', '/provider/{id:\d+}/edit', [ProviderController::class, 'edit']);
	$r->addRoute('POST', '/provider/{id:\d+}/update', [ProviderController::class, 'update']);
	$r->addRoute('POST', '/provider/{id:\d+}/delete', [ProviderController::class, 'delete']);

	$r->addRoute('GET', '/users', [UserController::class, 'index']);
	$r->addRoute('GET', '/user/new', [UserController::class, 'new']);
	$r->addRoute('POST', '/user/create', [UserController::class, 'create']);
	$r->addRoute('GET', '/user/{id:\d+}/edit', [UserController::class, 'edit']);
	$r->addRoute('POST', '/user/{id:\d+}/update', [UserController::class, 'update']);
	$r->addRoute('POST', '/user/{id:\d+}/delete', [UserController::class, 'delete']);

	$r->addRoute('GET', '/inventory', [InventoryController::class, 'index']);

	$r->addRoute('GET', '/sells', [SellController::class, 'index']);
	$r->addRoute('GET', '/sell/{id:\d+}', [SellController::class, 'show']);
	$r->addRoute('POST', '/sell/{id:\d+}/delete', [SellController::class, 'delete']);

	$r->addRoute('GET', '/pos', [PosController::class, 'index']);
	$r->addRoute('GET', '/pos/search', [PosController::class, 'search']);
	$r->addRoute('GET', '/pos/cart', [PosController::class, 'cartSummary']);
	$r->addRoute('POST', '/pos/cart/add', [PosController::class, 'addToCart']);
	$r->addRoute('POST', '/pos/cart/remove', [PosController::class, 'removeFromCart']);
	$r->addRoute('GET', '/pos/cart/clear', [PosController::class, 'clearCart']);
	$r->addRoute('POST', '/pos/checkout', [PosController::class, 'checkout']);

	$r->addRoute('GET', '/box', [BoxController::class, 'index']);
	$r->addRoute('GET', '/box/history', [BoxController::class, 'history']);
	$r->addRoute('GET', '/box/{id:\d+}', [BoxController::class, 'show']);
	$r->addRoute('POST', '/box/process', [BoxController::class, 'process']);

	$r->addRoute('GET', '/repos', [ReposController::class, 'index']);
	$r->addRoute('GET', '/repos/search', [ReposController::class, 'search']);
	$r->addRoute('GET', '/repos/cart', [ReposController::class, 'cartSummary']);
	$r->addRoute('POST', '/repos/cart/add', [ReposController::class, 'addToCart']);
	$r->addRoute('POST', '/repos/cart/remove', [ReposController::class, 'removeFromCart']);
	$r->addRoute('GET', '/repos/cart/clear', [ReposController::class, 'clearCart']);
	$r->addRoute('POST', '/repos/checkout', [ReposController::class, 'checkout']);

	$r->addRoute('GET', '/purchases', [PurchaseController::class, 'index']);
	$r->addRoute('GET', '/purchase/{id:\d+}', [PurchaseController::class, 'show']);
	$r->addRoute('POST', '/purchase/{id:\d+}/delete', [PurchaseController::class, 'delete']);

	$r->addRoute('GET', '/reports/movements', [ReportController::class, 'movements']);
	$r->addRoute('GET', '/reports/sales', [ReportController::class, 'sales']);

	$r->addRoute('GET', '/alerts', [AlertController::class, 'index']);

	$r->addRoute('GET', '/profile', [ProfileController::class, 'index']);
	$r->addRoute('POST', '/profile/change-password', [ProfileController::class, 'changePassword']);

	$r->addRoute('GET', '/settings', [SettingsController::class, 'index']);
	$r->addRoute('POST', '/settings/update', [SettingsController::class, 'update']);
};
