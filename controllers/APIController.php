<?php

namespace Controllers;
use Model\Cita;
use MVC\Router;
use Model\Servicio;
use Model\CitaServicio;

class APIController {
    public static function index() { // Esto genera una url en la que se traen todos los servicios u datos que obtengas de la BD        
        $servicios = Servicio::all();
        echo json_encode( $servicios ) ; 
    }

    public static function guardar() {

        // Almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacena los servicios con el id de la cita
        $idServicios = explode(',', $_POST['servicios']); // Dividimos los servicios para que cada uno ocupe una posicion en el arreglo
        foreach($idServicios as $idServicio) { // Iteramos sobre el arreglo con los id de los servicios
            $args = [ // Este arreglo nos da un nuevo arreglo asociativo con citaId con el id que obtuvimos y va guardando cada id de los serivicios
                'citasId' => $id,
                'serviciosId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args); // Creamos la clase y le damos nuestros argumentos para el constructor
            $citaServicio->guardar(); // Lo guardamos
        }

        echo json_encode(['resultado' => $resultado]);
    }
}