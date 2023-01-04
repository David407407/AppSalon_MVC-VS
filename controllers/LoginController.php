<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;

class LoginController {
    public static function login(Router $router) {
        $router->render('auth/login'); // Método render esta creado en el router, toma diversos datos en forma de arreglo, el primer dato es el del archivo que va a renderizar, no hace falta ponerle la extensión y ya esta apuntando a la carpeta de views automaticamente
    }
    public static function logout() {
        echo "Desde Logout";
    }
    public static function olvide(Router $router) {
        $router->render('auth/olvide', [
            
        ]);
    }
    public static function recuperar() {
        echo "Desde Recuperar";
    }
    public static function crear(Router $router) {
        $usuario = new Usuario;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario
        ]);
    }
}