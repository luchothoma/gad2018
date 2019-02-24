<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/slimConfig.php';

use \Slim\App;
use \Slim\Http\UploadedFile;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Pixie as Pixie;

$app = new App(['settings' => $slim_configuration]);

// As we have Slim\Container object, we can add our services to it.
$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/images/pokemon';

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

// Upload an image
$app->post('/upload', function(Request $request, Response $response) {
    
    $directory = $this->get('upload_directory');

    $uploadedFiles = $request->getUploadedFiles();

    $uploadedFile = $uploadedFiles['file'];

    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        $filename = moveUploadedFile($directory, $uploadedFile);
        return $response->withJson(array('filename' => $filename));
    }
    
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