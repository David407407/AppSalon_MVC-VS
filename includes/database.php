<?php

$db = mysqli_connect('localhost', 'root', 'Root', 'appsalon_mvc'); // Primero el host, luego el usuario, la contraseña  y por último el nombre de la tabla


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
