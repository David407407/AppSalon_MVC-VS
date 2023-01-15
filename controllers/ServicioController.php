<?php 
namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServicioController {
    public static function index(Router $router) {
        isAdmin();
        $servicios = Servicio::all();
        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router) {
        isAdmin();
        $alertas = [];
        $servicio = new Servicio;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validarServicio();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $alertas = Servicio::getAlertas();
        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router) {
        isAdmin();
        $alertas = [];
        if(!is_numeric($_GET['id'])) return;
        $servicio = Servicio::find($_GET['id']);
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validarServicio();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        $alertas = Servicio::getAlertas();
        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);
    }

    public static function eliminar(Router $router) {
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio = Servicio::find($_POST['id']);
            
            if(!empty($servicio)) {
                $servicio->eliminar();
                header('Location: /servicios');
            }
        }
    }
}