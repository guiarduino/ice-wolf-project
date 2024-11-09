<?php

use app\Controllers\UserController;
use Slim\Factory\AppFactory;

date_default_timezone_set('America/Sao_Paulo');
$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/users', UserController::class . ':show')->setName('user.show');
$app->get('/users/find', UserController::class . ':findBy')->setName('user.findBy');
$app->get('/users/{id}', UserController::class . ':find')->setName('user.find');
$app->post('/users', UserController::class . ':store')->setName('user.store');
$app->put('/users/{id}', UserController::class . ':update')->setName('user.update');
$app->delete('/users/{id}', UserController::class . ':delete')->setName('user.delete');

function showRoutes()
{
	global $app;
	$routes = $app->getRouteCollector()->getRoutes();

	// Definir cores usando códigos ANSI
	$http_color = [
		'DELETE' => "\e[31m",
		'GET' => "\e[32m",
		'HEAD' => "\e[32m",
		'POST' => "\e[33m",
		'PUT' => "\e[34m",
		'PATCH' => "\e[36m",
		'RESET' => "\e[0m"
	];

	// Largura fixa para as colunas
	$nameWidth = 30;
	$methodWidth = 10;
	$schemeWidth = 6;
	$hostWidth = 6;
	$pathWidth = 25;

	// Cabeçalho da tabela
	echo "+" . str_pad("", $nameWidth + 2, '-') . "+" . str_pad("", $methodWidth + 2, '-') . "+" . str_pad("", $schemeWidth + 2, '-') . "+" . str_pad("", $hostWidth + 2, '-') . "+" . str_pad("", $pathWidth + 2, '-') . "+\n";
	echo "| " . str_pad("Name", $nameWidth) . " | " . str_pad("Method", $methodWidth) . " | " . str_pad("Scheme", $schemeWidth) . " | " . str_pad("Host", $hostWidth) . " | " . str_pad("Path", $pathWidth) . " |\n";
	echo "+" . str_pad("", $nameWidth + 2, '-') . "+" . str_pad("", $methodWidth + 2, '-') . "+" . str_pad("", $schemeWidth + 2, '-') . "+" . str_pad("", $hostWidth + 2, '-') . "+" . str_pad("", $pathWidth + 2, '-') . "+\n";

	// Gerar as linhas da tabela
	foreach ($routes as $route) {

		// Nome da rota (pode ser ajustado conforme seu sistema de roteamento)
		$name = $route->getName() ?: strtolower(str_replace(['{', '}'], '_', $route->getPattern()));
		$method = implode(', ', $route->getMethods());
		$path = $route->getPattern();

		// Campos de Scheme e Host podem ser "ANY" já que o Slim não fornece diretamente essas informações
		$scheme = 'ANY';
		$host = 'ANY';
		
		// Exibe a linha da tabela com os dados das rotas
		echo "| " . str_pad($name, $nameWidth) . " | " . $http_color[$method] . str_pad($method, $methodWidth) . $http_color['RESET'] . " | " . str_pad($scheme, $schemeWidth) . " | " . str_pad($host, $hostWidth) . " | " . str_pad($path, $pathWidth) . " |\n";
	}

	// Rodapé da tabela
	echo "+" . str_pad("", $nameWidth + 2, '-') . "+" . str_pad("", $methodWidth + 2, '-') . "+" . str_pad("", $schemeWidth + 2, '-') . "+" . str_pad("", $hostWidth + 2, '-') . "+" . str_pad("", $pathWidth + 2, '-') . "+\n";
}

function appRun()
{
	global $app;
	$app->run();
}