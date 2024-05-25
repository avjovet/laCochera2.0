function showPagoModal() {
    document.body.classList.remove('modal-confirm-open');

    console.log("abierto")
    document.body.classList.add('modal-open');
    document.body.classList.add('modal-pago-open');
    const pagoModal = document.getElementById('pagoModal');
    pagoModal.style.display = 'block';
    hiddenBar();
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
