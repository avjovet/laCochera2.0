window.onload = function() {
    console.log('script.js cargado');  // Verifica que el script está cargado

    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");
    const searchBtn = document.querySelector(".bx-search");

    closeBtn.addEventListener("click", function() {
        sidebar.classList.toggle("open");
        menuBtnChange();
    });

    searchBtn.addEventListener("click", function() {
        sidebar.classList.toggle("open");
        menuBtnChange();
    });

    function menuBtnChange() {
        if (sidebar.classList.contains("open")) {
            closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else {
            closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const productoSelects = document.querySelectorAll('.producto-select');

        productoSelects.forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const precioUnitario = selectedOption.getAttribute('data-precio');
                const precioUnitarioCell = this.closest('tr').querySelector('.precio-unitario');

                precioUnitarioCell.textContent = precioUnitario;
            });
        });

    });
}
    document.addEventListener('DOMContentLoaded', function() {
        const productoSelects = document.querySelectorAll('.producto-select');

        productoSelects.forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const precioUnitario = selectedOption.getAttribute('data-precio');
                const precioUnitarioCell = this.closest('tr').querySelector('.precio-unitario');

                precioUnitarioCell.textContent = precioUnitario;
            });
        });

        // Función para actualizar los contadores de notificaciones
        function updateNotificationCounters() {
            // Actualizar contador para Pedidos Pendientes
            fetch('get_pending_orders_count.php')
                .then(response => response.text())
                .then(data => {
                    const counterElement1 = document.querySelector('#notif-counter'); // Primer contador de notificaciones
                    const count1 = parseInt(data, 10);

                    if (count1 > 0) {
                        counterElement1.textContent = count1;
                        counterElement1.style.display = 'inline';
                    } else {
                        counterElement1.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error al actualizar el contador de notificaciones (Pedidos Pendientes):', error));

            // Actualizar contador para Entregar Pedidos
            fetch('get_deliver_orders_count.php')  // Nueva consulta para obtener la cantidad de pedidos para entregar
                .then(response => response.text())
                .then(data => {
                    const counterElement2 = document.querySelector('#notif-counter2'); // Segundo contador de notificaciones
                    const count2 = parseInt(data, 10);

                    if (count2 > 0) {
                        counterElement2.textContent = count2;
                        counterElement2.style.display = 'inline';
                    } else {
                        counterElement2.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error al actualizar el contador de notificaciones (Entregar Pedidos):', error));
        }

        // Actualizar cada 10 segundos
        setInterval(updateNotificationCounters, 10000);

        // Actualizar al cargar la página
        updateNotificationCounters();
    });