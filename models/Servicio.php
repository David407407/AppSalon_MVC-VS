<?php
namespace Model;

class Servicio extends ActiveRecord {
    // BD
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'precio', 'nombre'];
    public $id;
    public $precio;
    public $nombre;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->precio = $args['precio'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
    }

    // Mensajes de validación al crear la cuenta
    public function validarServicio() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del servicio es obligatorio';
        }
        if(!$this->precio) {
            self::$alertas['error'][] = 'El precio del servicio es obligatorio';
        }
        if(!is_numeric($this->precio)) {
            self::$alertas['error'][] = 'El precio no es válido';
        }

        return self::$alertas;
    }
}