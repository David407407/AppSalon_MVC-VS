document.addEventListener('DOMContentLoaded', () => {
    iniciarApp();
});

function iniciarApp() {
    buscarPorFecha();
}

function buscarPorFecha() {
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', (e) => {
        const fechaSeleccionada = e.target.value;
        console.log(fechaSeleccionada);
        window.location = `?fecha=${fechaSeleccionada}`;
    });
}