<?php
require_once __DIR__ . '/vendor/autoload.php';

use \Slim\App;
use \Slim\Http\UploadedFile;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Pixie as Pixie;

$slim_configuration = require_once __DIR__ . '/slimConfig.php';
$app = new App(['settings' => $slim_configuration]);

// As we have Slim\Container object, we can add our services to it.
$container = $app->getContainer();

$container['db'] = function ($conf) {
    $PQBconfig = $conf['settings']['db'];
    $PQBconnection = new Pixie\Connection( $PQBconfig['driver'], $PQBconfig);
    return new Pixie\QueryBuilder\QueryBuilderHandler($PQBconnection);
};

// Register component on container
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('./views/');
};

// Define app routes
$app->get('/', function (Request $request, Response $response, array $args) {
	/*
	return $this->view->render($response, 'profile.html', [
        'name' => $args['name']
    ]);
    */
    return $this->view->render($response, 'main.php', []);
});

// Define app routes
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    return $response->withJson($args);
});

// Select All pokemon to a Postgres Database
$app->get('/selectAll', function (Request $request, Response $response, array $args) {
    $directory = $this->get('settings')['image_url'];
	$query = $this->db->query('select p.id, p.nombre,  CONCAT(\''.$directory.'\',p."nombreArchivo")
     as nombreArchivo from "pokemon" p');
    return $response->withJson($query->get());
});

//Get similar
$app->get('/similar/{idPokemon}[/{count}]', function (Request $request, Response $response, array $args) {
    $count=10;
    if(isset( $args['count'])){
         $count=$args['count'];
    }
	$query = $this->db->query('select ObtenerNPokemonsSimilares('.$count.', '.$args['idPokemon'].');');
    return $response->withJson($query->get());
});


// Upload an image
$app->post('/upload', function(Request $request, Response $response) {
   $uploadedFiles = $request->getUploadedFiles();

    $uploadedFile = $uploadedFiles['file'];

    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
    	$directory = $this->get('settings')['upload_directory'];
        $filename = moveUploadedFile($directory, $uploadedFile);
        return $response->withJson(array('filename' => $filename));
    }
    else
    	return $response->withJson(null);
    
});

// Move an uploaded file
function moveUploadedFile($directory, UploadedFile $uploadedFile) {
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}

// Run app
$app->run();