document.addEventListener('DOMContentLoaded', function() {
    // Obtener el formulario de pago
    var formPago = document.querySelector('#pagoModal form');

    // Agregar un manejador de eventos para el evento submit del formulario
    formPago.addEventListener('submit', function(event) {
        // Prevenir el comportamiento por defecto del formulario (enviar datos y recargar la página)
        event.preventDefault();

        // Aquí puedes agregar cualquier lógica adicional que desees antes de enviar los datos
        // Por ejemplo, podrías enviar los datos del formulario mediante AJAX al servidor
    });
});
