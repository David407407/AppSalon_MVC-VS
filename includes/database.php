<?php

$db = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_DB']); // Primero el host, luego el usuario, la contraseña  y por último el nombre de la tabla

$db->set_charset("utf8");
mysqli_set_charset($db, 'utf8mb4');

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
