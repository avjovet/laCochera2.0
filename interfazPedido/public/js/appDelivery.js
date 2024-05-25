function hiddenBar() {
    const body = document.body;
    const html = document.documentElement;

    if (body.classList.contains('modal-open')) {
        html.style.overflow = 'hidden';
    } else {
        html.style.overflow = 'auto';
    }
}

function showPagoModal() {
    console.log("abierto")
    document.body.classList.add('modal-open');
    const pagoModal = document.getElementById('pagoModal');
    pagoModal.style.display = 'block';
    hiddenBar();
}

function closePagoModal() {
    document.body.classList.remove('modal-open');
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
