<h1 class="nombre-pagina">Panel de Administracion</h1>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
                type="date"
                id='fecha'
                name='fecha'
                value="<?php echo $fecha ?>"
            />
        </div>
    </form>
</div>

<?php
    if(count($citas) === 0) {
        echo '<h2>No hay citas en esta fecha</h2>';
    }
?>

<div class="citas-admin">
    <ul class="citas">
        <?php 
        $idCita = 0; // Este es un inicializador ya que ninguna cita puede empezar en 0
         foreach( $citas as $key => $cita): // citas es el objeto global, key es la posicion del objeto actual y cita es el objeto actual
                if($idCita !== $cita->id): // Esta if evita que se duplique el codigo que no queremos que se repita
                    $total = 0;
            ?>
            <li id="cita">
                <p>ID: <span> <?php echo $cita->id ?></span></p>
                <p>Hora: <span> <?php echo $cita->hora ?></span></p>
                <p>Cliente: <span> <?php echo $cita->cliente ?></span></p>
                <p>Email: <span> <?php echo $cita->email ?></span></p>
                <p>Telefono: <span> <?php echo $cita->telefono ?></span></p>

                <h3>Servicios:</h3>
            <?php
                $idCita = $cita->id; // Aqui le decimos que idCita es el actual id para que ya no lo vuelva a repetir
                endif; 
            ?>
                <p class="servicio"><?php echo $cita->servicio . " $" . $cita->precio; ?></p> <!-- Este parrafo esta dentro del bucle asi que imprime los servicios repetidamente -->
            <?php 
                $total += $cita->precio; // Vamos sumando los precios de los servicios
                $actual = $cita->id; // Le indicamos que id es el actual
                $proximo = $citas[$key + 1]->id ?? 0; // Le indicamos cual sera el proximo id y si no hay es 0

            if(esUltimo($actual, $proximo) ) { // Esta funcion toma el id actual y el proximo, si son iguales no ejecuta el codigo sino hasta que sean diferentes, esto hace que le codigo dentro solo se ejecute una sola vez y es hasta que obtengamos el ultimo servicio ya que ahi cambiarian las posiciones ?> 
                <p class="total">Total a Pagar: <span>$<?php echo $total; ?></span></p>
                <!-- <button class="boton eliminar">Eliminar</button> -->
                <form id="contenedor-boton" method="POST" action="/api/eliminar">
                    <input type="hidden" name="id" value="<?php echo $cita->id ?>">
                </form>
            <?php }
        endforeach; ?>
    </ul>
</div>

<?php
    $script = "
        <script src='build/js/eliminar.js'></script>
        <script type='module' src='build/js/buscador.js'></script>
        <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    ";
?>