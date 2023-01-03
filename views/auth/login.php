<h1 class="nombre-pagina" >Login</h1>
<p class="descripcion-pagina" >Inicia sesión con tus datos</p>

<form action="/" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Contraseña" name="password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">

    <div class="acciones">
        <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
        <a href="/olvide">¿Olvidaste tu contraseña?</a>
    </div>
</form>