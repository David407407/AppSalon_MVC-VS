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
}