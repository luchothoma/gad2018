<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/slimConfig.php';

use \Slim\App;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Pixie as Pixie;

$app = new App(['settings' => $slim_configuration]);

// As we have Slim\Container object, we can add our services to it.
$container = $app->getContainer();

$container['db'] = function ($conf) {
    $PQBconfig = $conf['settings']['db'];
    $PQBconnection = new Pixie\Connection( $PQBconfig['driver'], $PQBconfig);
    return new Pixie\QueryBuilder\QueryBuilderHandler($PQBconnection);
};

// Define app routes
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    return $response->withJson($args);
});

// Query example to a Postgres Database
$app->get('/try-database', function (Request $request, Response $response, array $args) {
	$query = $this->db->query('select * from "Alumnos"');
    return $response->withJson($query->get());
});

// Run app
$app->run();