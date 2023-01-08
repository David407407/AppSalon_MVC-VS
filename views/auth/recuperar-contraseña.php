<h1 class='nombre-pagina' >Cambia tu Contraseña</h1>
<p class="descripcion-pagina" >Introduce tu nueva contraseña a continuación:</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<?php if($error) return;?>

<form method="POST" class="formulario">

    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu Nueva Contraseña"
        />
    </div>

    <input type="submit" class="boton" value="Cambiar Contraseña">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
</div>