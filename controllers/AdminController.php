<?php

namespace Controllers;
use Model\Cita;
use MVC\Router;
use Model\AdminCita;

class AdminController {
    public static function index(Router $router) {

        isAdmin();
        $fecha = $_GET['fecha'] ?? date('Y-m-d'); // Obtenemos la fecha ya sea de la URL o del servidor directamente
        $fechaSeleccionada = explode('-', $fecha); // La fecha la convertimos en arreglo
        if(!checkdate($fechaSeleccionada[1], $fechaSeleccionada[2], $fechaSeleccionada[0])) { // Si la fecha no es valida (devuelve false) manda al usuario a la pagina de error y deja de ejecutar el resto del codigo
            header('Location: /404');
        }

        // Consultar la BD
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citasId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.serviciosId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";

        $citas = AdminCita::SQL($consulta);
        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}