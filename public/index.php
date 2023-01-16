<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\AdminController;
use Controllers\LoginController;
use Controllers\ServicioController;

$router = new Router();

// Iniciar Sesión
$router->get('/', [LoginController::class, 'login']); // Lo primero es la URL, lo segundo es el controlador y la función de este que va a ser utilizada
$router->post('/', [LoginController::class, 'login']); 

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();