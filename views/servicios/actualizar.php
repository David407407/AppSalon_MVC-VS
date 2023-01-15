<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Modifica los Valores del Servicio</p>

<?php 
    include __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . "/../templates/alertas.php";

?>

<form class="formulario" method="POST">
    <?php 
        include __DIR__ . '/formulario.php';
    ?>

    <input type="submit" class="boton" value="Actualizar Servicio">
</form>