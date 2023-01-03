<?php

namespace Controllers;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $router->render('auth/login'); // Método render esta creado en el router, toma diversos datos en forma de arreglo, el primer dato es el del archivo que va a renderizar, no hace falta ponerle la extensión y ya esta apuntando a la carpeta de views automaticamente
    }
    public static function logout() {
        echo "Desde Logout";
    }
    public static function olvide() {
        echo "Desde Olvide";
    }
    public static function recuperar() {
        echo "Desde Recuperar";
    }
    public static function crear() {
        echo "Desde Crear Cuenta";
    }
}