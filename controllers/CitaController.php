<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Classes\Email;
use PHPMailer\PHPMailer\PHPMailer;

class CitaController {
    public static function index( Router $router) {
        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre']
        ]);
    }
}