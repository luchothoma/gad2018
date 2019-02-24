<?php
function configuration(){
	// General Configuration
	$slim_configuration['displayErrorDetails'] = true;
	$slim_configuration['addContentLengthHeader'] = false;

	// Postgres Database Configuration - Pixie Query Builder
	// https://github.com/usmanhalalit/pixie
	// https://packagist.org/packages/usmanhalalit/pixie#2.0.0
	$slim_configuration['db'] = [
		'driver'   	=> 	'pgsql',
		'host'     	=> 	'localhost',
		'port'	   	=>	5432,
		'database' 	=> 	'facultad',
		'username' 	=> 	'postgres',
		'password' 	=> 	'postgres',
		'schema'   	=> 	'public',
		'charset'  	=> 	'utf8',	
	];

	$slim_configuration['upload_directory'] = __DIR__ . '/images/pokemon';

	return $slim_configuration;
}

return configuration();