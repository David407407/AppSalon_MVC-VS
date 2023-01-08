<h1 class="nombre-pagina" >Login</h1>
<p class="descripcion-pagina" >Inicia sesión con tus datos</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>
<form action="/" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu Email"
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu Contraseña"
        />
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">

    <div class="acciones">
        <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
        <a href="/olvide">¿Olvidaste tu contraseña?</a>
    </div>
</form>