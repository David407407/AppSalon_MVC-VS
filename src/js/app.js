
// Public es la versión compilada, en src escribiremos el código
let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() { // Esta funcion se manda a llamar una vez, solo cuando se carga la pagina
    mostrarSeccion(); // muestra y oculta las secciones
    tabs(); // Cambia la sección cuando se presionan los tabs
    botonesPaginador(); // Agrega o quita los botones al paginador
    paginaSiguiente();
    paginaAnterior();

    consultarAPI(); // Consulta la API en el backend de PHP

    nombreCliente(); // Añade le nombre del cliente a la cita
    seleccionarFecha(); // Añade la fecha de la cita a la cita
    seleccionarHora(); // Añade la hora de la cita a la cita

    mostrarResumen(); // Muestra el resumen de la cita
}

function mostrarSeccion() {
    // Ocultar la seccion que se muestra
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }
    // Seleccionar la seccion con el paso
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    // Remueve el tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior) { 
        tabAnterior.classList.remove('actual'); 
    }
    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
    
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button'); // Nos trae un tipo arreglo con los botones
    botones.forEach( boton => { // Al igual que en php foreach itera sobre el arreglo dandonos boton a boton
        boton.addEventListener('click', (e) => { // Con e adquirimos toda la información sobre lo cual hicimos click
            paso = parseInt(e.target.dataset.paso); // Obtenemos el atributo que le colocamos como numero y se lo vamos pasando a la variable de paso

            mostrarSeccion(); // Mandamos a llamar la función en cuanto damos click
            //Muestra los botones 
            botonesPaginador();
        });
    });
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if(paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', () => {
        if(paso >= pasoFinal) return;
        paso++;

        botonesPaginador();
    });
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', () => {
        if(paso <= pasoInicial) return;
        paso--;

        botonesPaginador();
    });
}

async function consultarAPI() { // async sirve para usar await el cual es ideal para consumir una API

    try { // Permite que se ejecute el resto de la app sin que se detenga el código JS
        const url = 'http://localhost:8888/api/servicios';
        const resultado = await fetch(url); // await hace que se detenga el resto del código hasta que este fetch se haya terminado
        const servicios = await resultado.json(); // convierte de json a objetos lo obtenido
        mostrarServicios(servicios); // le pasamos los objetos que acabamos de obtener
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios (servicios) {
    servicios.forEach(servicio => { // iteramos sobre cada uno de los objetos obtenidos 
        const { id, nombre, precio } = servicio; // creamos una variable para cada parametro del objeto

        // Creamos el parrafo que contiene el nombre del servicio
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        // Creamos el parrafo que contiene el precio del servicio
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        // Creamos el div que contiene a el resto de los parrafos
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = () => { // Usamos este callback para que la funcion solo se llame cuando demos click, de otro modo se llamaría la función cuando se mande a llamar la otra
            seleccionarServicio(servicio);
        };

        // Agregamos al div los elementos creados
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        // Agregamos el div creado con js al div donde queremos que se muestren los servicios
        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita; // Obtenemos la propiedad de servicios del objeto de cita

    // Identificar el elemento al que se le da click, ya que ya le estamos pasando el servicio y su id al dar click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`); 
    // Comprobar si el servicio fue comprobado
    if( servicios.some( agregado => agregado.id === id ) ) { // Este metodo nos devuelve true(si es igual al elemento actual) o false(si es diferente al elemento actual), agregado se refiere al elemento actual que estamos seleccionando, y le decimos que si el id del actual elemento es igual a algun otro id del arreglo nos devuelva true
        // Eliminarlo
        cita.servicios = servicios.filter( agregado => agregado.id !== id ); // Este metodo busca el servicio que sea igual al actual y lo borra, este metodo funciona al reves pues le decimos que mantenga todo elemento que no sea igual al id actual
        divServicio.classList.remove('seleccionado'); // Le removemos la clase de seleccionado al id actual
    } else {
        // Agregarlos
        cita.servicios = [...servicios, servicio]; // A la propiedad le agregamos un arreglo que va a contener la copia del primer arreglo más el servicio que le estamos pasando, es importante que sea una copia ya que primero agrega el servicio al arreglo copia y luego le pasa el nuevo arreglo
        divServicio.classList.add('seleccionado');
    }

    console.log(cita);
}

function nombreCliente() {
    const nombre = document.querySelector('#nombre').value; // Como ya esta asignado el nombre solo tenemos que obtener el dato del input mediante value
    cita.nombre = nombre; // Le asignamos el nombre a la cita
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', (e) => { // Se dispara la funcion cuando el usuario selecciona un dato
        const dia = new Date(e.target.value).getUTCDay(); // Obtenemos la fecha en cuestion de los dias de la semana
        if( [6, 0].includes(dia) ) { // 0 y 6 es domingo y sabado por lo que si nuestra fecha incluye alguno de estos dos se dispara el if
            e.target.value = ''; // Elimina el valor de la fecha
            mostrarAlerta('Fines de semana no Permitidos', 'error', '.formulario'); // Muestra la alerta
        } else {
            cita.fecha = e.target.value; // Como no son los dias que prohibimos podemos agregar la fecha con exito
        }
    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', (e) => {
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        if(hora < 10 || hora > 18) {
            e.target.value = ''; // Elimina el valor de la fecha
            mostrarAlerta('Hora no Válida', 'error', '.formulario'); // Muestra la alerta
        } else {
            cita.hora = e.target.value;
        }

    });
}

function mostrarAlerta(mensaje, tipo, referencia, desaparece = true) {
    // Previene que se genere más de una alerta
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) { // Si existen alertas previas las elimina para que se puedan crear nuevas alertas
        alertaPrevia.remove();
    }
    // Crea la alerta
    const alerta = document.createElement('DIV'); 
    alerta.textContent = mensaje; // Le incluimos el mensaje de la alerta
    alerta.classList.add('alerta'); // Le agregamos la clase
    alerta.classList.add(tipo); // Le agregamos el tipo
    const ubicacion = document.querySelector(referencia); // Este es el elemento de referencia donde queremos insertar la alerta
    ubicacion.appendChild(alerta); // Insertamos la alerta

    if(desaparece) {
        setTimeout(() => { // Le decimos que elimine la alerta despues de cierto tiempo
            alerta.remove();
        }, 3000);
    }
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar el contenido de resumen
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if( Object.values(cita).includes('') || cita.servicios.length === 0) { // Object.values accede a los valores del objeto y te los trae en forma de arreglo, con el includes le decimos que si existe dicho elemento en el arreglo entoces devuelva true sino false
        mostrarAlerta( 'Faltan agregar datos a su cita', 'error', '.contenido-resumen', false);
        return;
    } 

    // Formatear el div de resumen
    const { nombre, fecha, hora, servicios } = cita;

    // Encabezado de la sección
    const headingResumen = document.createElement('H3');
    headingResumen.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingResumen);

    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio; // Destructuring sirve para obtener la informacion de las propiedades de los objetos que le estamos pasando
        const contendorServicio = document.createElement('DIV');
        contendorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`; // Inner sirve para crear HTML en JS ya que de otra forma lo lee como texto plano

        contendorServicio.appendChild(textoServicio);
        contendorServicio.appendChild(precioServicio);

        resumen.appendChild(contendorServicio);
    });

    // Encabezado de la sección
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de la Cita';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Creamos el objeto de fecha usando la fecha que ya tenemos, el dia le agregamos un dos ya que por cada vez que instanseemos Date se atrasa un día 
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    // Creamos el objeto en UTC para que lo acepte el metodo de localDateString
    const fechaUTC = new Date( Date.UTC(year, mes, dia) );

    // Formatear la fecha en español con es-MX, luego le pasamos las opciones para que la variable se muestre en la forma que queremos, en este caso long significa que el valor debe ser en string y no en número y numeric si es en número
    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);
}

async function reservarCita() {
    const datos = new FormData();
    datos.append();

    // Peticion hacia la api
    const url = 'http://localhost:8888/api/citas';
    const respuesta = await fetch(url, {
        method: 'POST'
    });

    console.log(respuesta);
    // console.log([...datos]); De esta forma es posible ver los datos que se estan enviando 
}