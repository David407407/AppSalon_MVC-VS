<?php
namespace Model;

class Usuario extends ActiveRecord {
    // BD
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password','telefono', 'admin', 'confirmado', 'token'];
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    // Mensajes de validación al crear la cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido del cliente es obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El email del cliente es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña del cliente es obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El teléfono del cliente es obligatorio';
        }
        if(\strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La Contraseña debe contener 6 caracteres mínimo';
        }

        return self::$alertas;
    }

    public function validarCuenta() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email del cliente es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña del cliente es obligatoria';
        }
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email del cliente es obligatorio';
        }
    }
    public function validarContraseña() {
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña del cliente es obligatoria';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La Contraseña debe contener 6 caracteres mínimo';
        }
    }

    // Revisa si el usuario ya existe
    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1"; // Siempre que nos querramos referir a una consulta en la BD crearemos la variable query la cual debe contener la instruccion en formato SQL

        $resultado = self::$db->query($query); // recordemos que db es la BD y el metodo query nos permite hacer consultas en la BD y traernos el resultado si es que encontro algo
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }

        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function crearToken() {
        $this->token = uniqid();
    }
    public function comprobarContraseñaAndVerificado($password) {
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Tu Contraseña es incorrecta o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }
}