<?php

// General Configuration
$slim_configuration['displayErrorDetails'] = true;
$slim_configuration['addContentLengthHeader'] = false;

// Postgres Database Configuration
$slim_configuration['db'] = [
	'host' => 'localhost',
	'user' => 'user',
	'pass' => 'password',
	'dbname' => 'exampleapp',
];