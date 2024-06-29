document.addEventListener('DOMContentLoaded', function() {
    const tipoPedidoSelect = document.getElementById('tipo_pedido');
    const mesaContainer = document.getElementById('mesa-container');
    const form = document.querySelector('form');
    const mesaSelect = document.getElementById('mesa_id');

    // Muestra/oculta el select de mesa basado en el tipo de pedido
    tipoPedidoSelect.addEventListener('change', function() {
        if (tipoPedidoSelect.value == '1') {
            mesaContainer.style.display = 'block';
        } else {
            mesaContainer.style.display = 'none';
        }
    });

    // Inicializa el estado del select de mesa basado en el tipo de pedido actual
    if (tipoPedidoSelect.value == '1') {
        mesaContainer.style.display = 'block';
    } else {
        mesaContainer.style.display = 'none';
    }

    // Validar el formulario antes de enviarlo
    form.addEventListener('submit', function(event) {
        const tipoPedido = tipoPedidoSelect.value;
        const mesa = mesaSelect.value;

        if (tipoPedido == '' || (tipoPedido == '1' && mesa == '')) {
            event.preventDefault();
            alert('Por favor, selecciona un tipo de pedido y un número de mesa.');
        }
    });
});
