<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/slimConfig.php';

use \Slim\App;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new App(['settings' => $slim_configuration]);

// Define app routes
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    return $response->withJson($args);
});

// Run app
$app->run();