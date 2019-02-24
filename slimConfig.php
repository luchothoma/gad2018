<?php
function configuration(){
	// General Configuration
	$slim_configuration['displayErrorDetails'] = true;
	$slim_configuration['addContentLengthHeader'] = false;

	$slim_configuration['base_url'] = ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? "https":"http" )."://".$_SERVER['SERVER_NAME'].str_replace("index.php", "",  $_SERVER['SCRIPT_NAME']);
	$slim_configuration['image_url'] = $slim_configuration['base_url'].'images/pokemon/';

	$slim_configuration['upload_directory'] = __DIR__ . '/images/pokemon';

	// Postgres Database Configuration - Pixie Query Builder
	// https://github.com/usmanhalalit/pixie
	// https://packagist.org/packages/usmanhalalit/pixie#2.0.0
	$slim_configuration['db'] = [
		'driver'   	=> 	'pgsql',
		'host'     	=> 	'localhost',
		'port'	   	=>	5432,
		'database' 	=> 	'GAD',
		'username' 	=> 	'postgres',
		'password' 	=> 	'postgres',
		'schema'   	=> 	'public',
		'charset'  	=> 	'utf8',	
	];

	return $slim_configuration;
}

return configuration();