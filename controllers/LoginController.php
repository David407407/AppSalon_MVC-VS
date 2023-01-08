<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Classes\Email;
use PHPMailer\PHPMailer\PHPMailer;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarCuenta(); // Checa si los campos no están vacios, si lo están crea un mensaje de error

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if(empty($usuario)) {
                    Usuario::setAlerta('error', 'No Existe tu Cuenta');
                } else {
                    if($usuario->comprobarContraseñaAndVerificado($auth->password)) {
                        // Autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas
        ]); // Método render esta creado en el router, toma diversos datos en forma de arreglo, el primer dato es el del archivo que va a renderizar, no hace falta ponerle la extensión y ya esta apuntando a la carpeta de views automaticamente y como segundo dato toma las variables que queremos que estén disponibles dentro del archivo
    }
    public static function logout() {
        echo "Desde Logout";
    }
    public static function olvide(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            
            if(empty($alertas)) {
                // Buscar cual es el usuario que quiere cambiar la contraseña
                $usuario = Usuario::where('email', $auth->email);
                // Crear y enviar el email
                $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                $email->cambiarContraseña();
                // Decirle al usuario que el email se envio
                Usuario::setAlerta('exito', 'El email ha sido enviado');
                // Crear el token
                $usuario->crearToken();
                // Actualizar el token
                $usuario->actualizar();
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide', [
            'alertas' => $alertas,
        ]);
    }
    public static function recuperar(Router $router) {
        $alertas = [];
        // Sanitizar el token y obtenerlo
        $token = s($_GET['token']);
        // Traernos el usuario gracias al token
        $usuario = Usuario::where('token', $token);
        debuguear($usuario);

        if(empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Modificar el registro a usuario confirmado
                $usuario->validarContraseña();
                if(empty($alertas)) {
                    $usuario->token = '';
                    $usuario->hashPassword();
                    debuguear($usuario);
                    // $usuario->actualizar();
                    Usuario::setAlerta('exito', 'Contraseña Cambiada Correctamente');
                }
            }
        }
        
        
        // Mostrar alertas
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-contraseña', [
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
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
                    // Crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        // Sanitizar el token y obtenerlo
        $token = s($_GET['token']);
        // Traernos el usuario gracias al token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            // Modificar el registro a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = '';
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }
        // Mostrar alertas
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }
}