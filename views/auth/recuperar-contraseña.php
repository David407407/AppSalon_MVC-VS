<h1 class='nombre-pagina' >Cambia tu Contraseña</h1>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form action="/recuperar" method="POST" class="formulario">

    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu Contraseña"
        />
    </div>

    <input type="submit" class="boton" value="Cambiar Contraseña">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
</div>