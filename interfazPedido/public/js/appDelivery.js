
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
    pagoModal.style.display = 'none';
    hiddenBar();
}

function showYapeOptions() {
    hidePaymentOptions();
    document.getElementById('yapeOptions').style.display = 'flex'; // Muestra los elementos de Yape
}

function showPlinOptions() {
    hidePaymentOptions();
    document.getElementById('plinOptions').style.display = 'flex'; // Muestra los elementos de Plin
}

function hidePaymentOptions() {
    document.getElementById('yapeOptions').style.display = 'none'; // Oculta los elementos de Yape
    document.getElementById('plinOptions').style.display = 'none'; // Oculta los elementos de Plin
}
