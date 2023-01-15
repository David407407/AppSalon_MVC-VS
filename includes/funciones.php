<?php

function debuguear($variable) : string { // Sirve para ver que esta ocurriendo con la variable
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Funcion que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function isAdmin() : void {
    if($_SESSION['admin'] !== "1") {
        header('Location: /');
    }
}

function esUltimo(string $actual, string $proximo) : bool {
    if($actual !== $proximo) {
        return true;
    }
    return false;
}