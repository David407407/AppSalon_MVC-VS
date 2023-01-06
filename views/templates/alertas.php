<?php foreach($alertas as $key => $mensajes): // alertas es un arreglo de arreglos asi que hay que tener cuidado al referirnos a el ?> 
    <?php foreach($mensajes as $mensaje): ?>
        <div class="alerta <?php echo $key; ?>">
            <?php echo $mensaje; ?> 
        </div> 
    <?php endforeach; ?>
<?php endforeach; ?>