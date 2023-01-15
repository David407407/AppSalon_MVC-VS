<?php 
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
use Model\ActiveRecord; // Usando ActiveRecord del archivo de Model se conecta a la base de datos
ActiveRecord::setDB($db);