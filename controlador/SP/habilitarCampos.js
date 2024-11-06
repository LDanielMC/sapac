// Fechas específicas para habilitar cada campo
const habilitarDeclaracion = new Date('2024-12-01');
const habilitarEntrega = new Date('2024-11-05');
const habilitarRecepcion = new Date('2024-11-20');

const hoy = new Date();

// Habilitar cada input si la fecha actual coincide con la definida
if (hoy >= habilitarDeclaracion) {
    document.getElementById('declaracion').disabled = false;
}
if (hoy >= habilitarEntrega) {
    document.getElementById('entrega').disabled = false;
}
if (hoy >= habilitarRecepcion) {
    document.getElementById('recepcion').disabled = false;
}
