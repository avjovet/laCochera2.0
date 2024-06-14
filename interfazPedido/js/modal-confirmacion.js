function verificarCarrito() {
    console.log("este es el carrito", carrito)
    if (carrito.length > 0) {
      _showModal('modal-confirm');
    } else {
      _showModal('modal-empty');
    }
  }

  function verificarCarritoLlevar() {
    const customerName = document.getElementById('customer-name').value.trim();
    console.log("este es el carrito", carrito);
    console.log("Nombre del cliente:", customerName);

    if (carrito.length === 0) {
      _showModal('modal-empty');
    } else if (!customerName) {
      _showModal('modal-name-empty');
    } else {
      _showModal('modal-confirm');
    }
  }

function setupModalCloseEvent(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                _closeModal(modalId); 
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setupModalCloseEvent('modal-confirm');
    setupModalCloseEvent('modal-mozo');
    setupModalCloseEvent('modal-confirmed');
    setupModalCloseEvent('modal-empty');
    setupModalCloseEvent('modal-name-empty');



});


function _showModal(modalId) {
    document.body.classList.add('modal-open');
    document.body.classList.add(`${modalId}-open`);
    const modal = document.getElementById(modalId);
    modal.style.display = 'block';
    hiddenBar();
}

function _closeModal(modalId) {
    document.body.classList.remove('modal-open');
    document.body.classList.remove(`${modalId}-open`);
    const modal = document.getElementById(modalId);
    modal.classList.add('closing'); // Agregar clase para activar animación de cierre

    // Agregar un tiempo de espera antes de ocultar completamente el modal
    setTimeout(function() {
        modal.style.display = 'none';
        modal.classList.remove('closing'); // Eliminar clase de animación de cierre
        hiddenBar();
    }, 300); // Tiempo igual al tiempo de la animación en milisegundos
}





function sendConfirmedPedido() {
    document.body.classList.remove('modal-open');
    document.body.classList.remove('modal-confirm-open');

    carritoPrepared();
    enviarPedido();
    _closeModal('modal-confirm');
    _showModal('modal-confirmed')
    closeSidebar();

    

}
function sendConfirmedPedidoLlevar() {
    document.body.classList.remove('modal-open');
    document.body.classList.remove('modal-confirm-open');
    carritoPrepared();
    enviarPedidoLlevar(); 
    _closeModal('modal-confirm');
    _showModal('modal-confirmed')
    closeSidebar();

}

function sendConfirmedPedidoDelivery() {
    document.body.classList.remove('modal-open');
    document.body.classList.remove('modal-confirm-open');
    carritoPrepared();
    enviarPedidoDelivery(); 
    _closeModal('modal-confirm');


}

window.onbeforeunload = function(event) {
    const body = document.body;
    if (body.classList.contains('modal-confirm-open')) {
        _closeModal('modal-confirm');
        return '¿Estás seguro de que deseas salir?'; 
    }
    if (!body.classList.contains('modal-open')){
        return '¿Estás seguro de que deseas salir?'; 

    }
    if (body.classList.contains('modal-product-open')){
        closeModal();
        return '¿Estás seguro de que deseas salir?'; 

    }
    if (body.classList.contains('modal-pago-open')){
        closePagoModal();
        return '¿Estás seguro de que deseas salir?'; 

    }

    if (body.classList.contains('modal-mozo-open')){
        _closeModal('modal-mozo');
        return '¿Estás seguro de que deseas salir?';

    }
};
