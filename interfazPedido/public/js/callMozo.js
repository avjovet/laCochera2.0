let callMozo = false; // Variable global para rastrear si se llama al mozo

document.addEventListener('DOMContentLoaded', function () {
    const btnMozo = document.getElementById('btnMozo');
    const confirmBtn = document.querySelector('#modal-mozo .send-btn');

    btnMozo.addEventListener('click', function () {
        if (!callMozo) {
            _showModal('modal-mozo');
        }
    });

    confirmBtn.addEventListener('click', function () {
        // Cambiar el contenido y el estilo del botón después de confirmar
        const icono = btnMozo.querySelector('i');
        if (btnMozo.classList.contains('clicked')) {
            btnMozo.classList.remove('clicked');
            btnMozo.querySelector('span:first-child').textContent = 'Llamar';
            btnMozo.querySelector('span:last-child').textContent = 'mozo';
            icono.style.color = ''; // Restaurar el color predeterminado del ícono
            callMozo = false; // Se cancela la llamada al mozo
        } else {
            btnMozo.classList.add('clicked');
            btnMozo.querySelector('span:first-child').textContent = 'Quitar';
            btnMozo.querySelector('span:last-child').textContent = 'llamado';
            icono.style.color = '#300500'; // Cambiar el color del ícono a rojo vino
            callMozo = true; // Se llama al mozo
        }
        
        // Puedes agregar cualquier lógica adicional aquí, como enviar el pedido, etc.

        // Luego cierras el modal
        _closeModal('modal-mozo');
    });

    // Restaurar el color del botón si se intenta llamar al mozo mientras ya está llamado
    btnMozo.addEventListener('click', function () {
        if (callMozo) {
            btnMozo.classList.remove('clicked');
            btnMozo.querySelector('span:first-child').textContent = 'Llamar';
            btnMozo.querySelector('span:last-child').textContent = 'mozo';
            btnMozo.querySelector('i').style.color = ''; // Restaurar el color predeterminado del ícono
            callMozo = false; // Se cancela la llamada al mozo
        }
    });
});
