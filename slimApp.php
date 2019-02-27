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
    if(isset($args['count'])){
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
    	$public_directory = $this->get('settings')['image_url'];
        $filename = moveUploadedFile($directory, $uploadedFile);
        $nombre = 'NOMBREharcodeado';
        $vector = createCharacteristicVector($directory.'/'.$filename);

        $data = array(
		    'nombre' => $nombre,
		    'nombreArchivo' => $filename,
		);

		foreach ($vector as $index=> $value) {
			$data['c'.($index+1)] = $value;
		}

        return $response->withJson([
        	'nombre' => $nombre,
        	'nombreArchivo' => $filename,
        	'id' => $this->db->table('pokemon')->insert($data),
        ]);
    }
    else
    	return $response->withJson(null);
    
});

// prueba
$app->get('/test', function(Request $request, Response $response) {
	/*
	$directory = $this->get('settings')['upload_directory'];
    $filename = "abra.png";
    
    $ti =  microtime(true);
    $v = createCharacteristicVector($directory.'/'.$filename);
    $tf =  microtime(true);

    return $response->withJson([
    	'vector' => $v,
    	'tiempo' => (($tf-$ti)/1000)
    ]);
    */
    /*
    $data = [
    	'nombre' => "Nombre",
    	'nombreArchivo' => "abra.png",
    	'c1' => 0.1,'c2' => 0.1,'c3' => 0.1,'c4' => 0.1,'c5' => 0.1,'c6' => 0.1,'c7' => 0.1,'c8' => 0.1,'c9' => 0.1,'c10' => 0.1,
    	'c11' => 0.1,'c11' => 0.1,'c13' => 0.1,'c14' => 0.1,'c15' => 0.1,'c16' => 0.1,'c17' => 0.1,'c18' => 0.1,'c19' => 0.1,'c20' => 0.1,
    	'c21' => 0.1,'c22' => 0.1,'c23' => 0.1,'c24' => 0.1,'c25' => 0.1,'c26' => 0.1,'c27' => 0.1,'c28' => 0.1,'c29' => 0.1,'c30' => 0.1,
    	'c31' => 0.1,'c32' => 0.1,'c33' => 0.1,'c34' => 0.1,'c35' => 0.1,'c36' => 0.1,'c37' => 0.1,'c38' => 0.1,'c39' => 0.1,'c40' => 0.1,
    ];
    return $response->withJson(['id' => $this->db->table('pokemon')->insert($data)]);
    */
});


function createCharacteristicVector(string $image_path){
	require_once 'classes/Image.php';
	require_once 'classes/VectorCaracteristico.php';

    $img = new Image($image_path);
    $vector = new VectorCaracteristico($img);

    return $vector->get();
}

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