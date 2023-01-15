<h1 class="nombre-pagina">Nuevo Servicio</h1>
<p class="descripcion-pagina">Crear Nuevo Servicio</p>

<?php 
    include __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . "/../templates/alertas.php";

?>

<form action="/servicios/crear" class="formulario" method="POST">
    <?php 
        include __DIR__ . '/formulario.php';
    ?>

    <input type="submit" class="boton" value="Guardar Servicio">
</form>