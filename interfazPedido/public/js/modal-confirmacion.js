function hiddenBar() {
    const body = document.body;
    const html = document.documentElement;

    if (body.classList.contains('modal-open')) {
        html.style.overflow = 'hidden';
    } else {
        html.style.overflow = 'auto';
    }
}
// Función para mostrar el modal de confirmación
function showConfirmModal() {
    document.body.classList.add('modal-open');
    const confirmModal = document.getElementById('confirmModal');
    confirmModal.style.display = 'block';
    hiddenBar();
}

// Función para cerrar el modal de confirmación
function closeConfirmModal() {
    document.body.classList.remove('modal-open');
    const confirmModal = document.getElementById('confirmModal');
    confirmModal.style.display = 'none';
    hiddenBar();
}

// Función para enviar el pedido después de confirmar
function sendConfirmedPedido() {
    document.body.classList.remove('modal-open');

    // Aquí puedes agregar la lógica para enviar el pedido
    // Por ejemplo, llamar a la función enviarPedido() que ya tienes
    enviarPedido();
    // Después de enviar el pedido, cierra el modal de confirmación
    closeConfirmModal();
}

// Función para enviar el pedido después de confirmar
function sendConfirmedPedidoLlevar() {
    document.body.classList.remove('modal-open');
    enviarPedidoLlevar(); // tienes q crear esta funcion
    closeConfirmModal();
}


