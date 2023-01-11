<?php

namespace Controllers;
use MVC\Router;
use Model\Servicio;

class APIController {
    public static function index() { // Esto genera una url en la que se traen todos los servicios u datos que obtengas de la BD        
        $servicios = Servicio::all();
        echo json_encode( $servicios ) ; 
    }
}