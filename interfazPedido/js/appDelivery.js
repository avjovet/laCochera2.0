
function showPagoModal() {
    
    console.log(carrito)
    const totalCarrito = carrito.reduce((total, producto) => total + producto.total, 0);
    console.log(totalCarrito);

    document.body.classList.remove('modal-confirm-open');

    console.log("abierto")
    document.body.classList.add('modal-open');
    document.body.classList.add('modal-pago-open');

    
    const pagoModal = document.getElementById('pagoModal');
    pagoModal.style.display = 'block';
    hiddenBar();

    // Seleccionar el elemento HTML que muestra el monto del pedido
    const montoPedidoElement = document.querySelector('.monto-pedido');

    // Actualizar el contenido del elemento HTML con el monto total del pedido
    montoPedidoElement.textContent = `S/. ${totalCarrito.toFixed(2)}`;
}

function closePagoModal() {
    document.body.classList.remove('modal-open');
    document.body.classList.remove('modal-pago-open');

    const pagoModal = document.getElementById('pagoModal');
    pagoModal.classList.add('closing'); // Agregar clase para activar animación de cierre

    // Agregar un tiempo de espera antes de ocultar completamente el modal
    setTimeout(function() {
        pagoModal.style.display = 'none';
        pagoModal.classList.remove('closing'); // Eliminar clase de animación de cierre
        hiddenBar();
    }, 300); // Tiempo igual al tiempo de la animación en milisegundos
}


function showYapeOptions() {
    hidePaymentOptions();
    document.getElementById('yapeOptions').classList.add('visible');
}

function showPlinOptions() {
    hidePaymentOptions();
    document.getElementById('plinOptions').classList.add('visible');
}

function hidePaymentOptions() {
    document.getElementById('yapeOptions').classList.remove('visible');
    document.getElementById('plinOptions').classList.remove('visible');
}
