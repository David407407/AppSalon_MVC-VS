<?php 

require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Model\ActiveRecord; // Usando ActiveRecord del archivo de Model se conecta a la base de datos
ActiveRecord::setDB($db);