// Public es la versión compilada, en src escribiremos el código
let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

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

        // Agregamos al div los elementos creados
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        // Agregamos el div creado con js al div donde queremos que se muestren los servicios
        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}