<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController {
    public static function login(Router $router) {
        $router->render('auth/login'); // Método render esta creado en el router, toma diversos datos en forma de arreglo, el primer dato es el del archivo que va a renderizar, no hace falta ponerle la extensión y ya esta apuntando a la carpeta de views automaticamente y como segundo dato toma las variables que queremos que estén disponibles dentro del archivo
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

        // Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST); // Sincroniza con lo visto escrito en la página
            $alertas = $usuario->validarNuevaCuenta(); // Checa si los campos no están vacios, si lo están crea un mensaje de error

            // Revisar que alertas este vacío
            if(empty($alertas)) {
                // Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    // Si esta registrado
                    $alertas = Usuario::getAlertas();
                } else {
                    // No esta registrado
                    //Hashear el password
                    $usuario->hashPassword();
                    // Generar un token
                    $usuario->crearToken();
                    // Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    debuguear($email);
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
}