document.addEventListener('DOMContentLoaded', function () {
    const btnMozo = document.getElementById('btnMozo');
    btnMozo.addEventListener('click', function () {
        const icono = this.querySelector('i');
        if (this.classList.contains('clicked')) {
            this.classList.remove('clicked');
            this.querySelector('span:first-child').textContent = 'Llamar';
            this.querySelector('span:last-child').textContent = 'mozo';
            icono.style.color = ''; // Restaurar el color predeterminado del ícono
        } else {
            this.classList.add('clicked');
            this.querySelector('span:first-child').textContent = 'Quitar';
            this.querySelector('span:last-child').textContent = 'llamado';
            icono.style.color = '#300500'; // Cambiar el color del ícono a rojo vino
        }
    });
});
