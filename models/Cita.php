<?php
namespace Model;

class Usuario extends ActiveRecord {
    // BD
    protected static $tabla = 'cita';
    protected static $columnasDB = ['id', 'usuarioId', 'hora', 'fecha'];
    public $id;
    public $usuarioId;
    public $hora;
    public $fecha;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
    }
}