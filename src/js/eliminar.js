document.addEventListener('DOMContentLoaded', () => {
    iniciarApp();
});

function iniciarApp() {
    crearBoton();
}

function crearBoton() {
    const cita = document.querySelectorAll('#cita');
    const contenedor = document.querySelectorAll('#contenedor-boton');

    contenedor.forEach( (contenido, indice) => {
        const botonEliminar = document.createElement('BUTTON');
        botonEliminar.classList.add('boton');
        botonEliminar.classList.add('eliminar');
        botonEliminar.textContent = 'Eliminar';
        contenido.appendChild(botonEliminar);
        botonEliminar.onclick = (() => {
            eliminarAlerta(cita[indice]);
        });
    });

}

function eliminarAlerta(cita) {
    // cita.remove();
}