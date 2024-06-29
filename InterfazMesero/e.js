document.addEventListener('DOMContentLoaded', function() {
    const agregarFilaButton = document.getElementById('agregar-fila');
    const pedidoTableBody = document.querySelector('#pedido-table tbody');
    const totalDisplay = document.getElementById('total-display');
    const eliminarDetalleInput = document.getElementById('eliminar_detalle_pedido_id');
    let productosData = [];

    // Cargar los datos de productos una vez
    document.querySelectorAll('.producto-select option').forEach(option => {
        productosData.push({
            id: option.value,
            nombre: option.textContent,
            precio: parseFloat(option.getAttribute('data-precio'))
        });
    });

    // Función para actualizar el precio unitario y el total
    function updatePrecioUnitario(select) {
        const selectedOption = select.options[select.selectedIndex];
        const precioUnitario = selectedOption.getAttribute('data-precio');
        const precioUnitarioCell = select.closest('tr').querySelector('.precio-unitario');
        precioUnitarioCell.textContent = precioUnitario;
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('#pedido-table tbody tr').forEach(row => {
            const cantidadInput = row.querySelector('.cantidad-input');
            const precioUnitarioCell = row.querySelector('.precio-unitario');
            if (cantidadInput && precioUnitarioCell) {
                const cantidad = parseFloat(cantidadInput.value) || 0;
                const precioUnitario = parseFloat(precioUnitarioCell.textContent) || 0;
                total += cantidad * precioUnitario;
            }
        });
        totalDisplay.textContent = "Total: $" + total.toFixed(2);
    }

    // Función para agregar una nueva fila al formulario
    function agregarFila() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td data-label='Cantidad'><input type='number' name='cantidad[]' value='1' class='cantidad-input'></td>
            <td data-label='Producto'>
                <select name='producto[]' class='producto-select'>
                    ${productosData.map(producto => `<option value='${producto.id}' data-precio='${producto.precio}'>${producto.nombre}</option>`).join('')}
                </select>
            </td>
            <td data-label='Notas'><input type='text' name='notas[]'></td>
            <td data-label='Precio Unitario' class='precio-unitario'>${productosData[0].precio}</td>
            <td data-label='Acciones' class='actions'><button class='boton-cancelar' type='button'>X Cancelar</button></td>
            <input type='hidden' name='detalle_pedido_id[]' value='0'>
        `;
        pedidoTableBody.appendChild(newRow);

        // Asignar eventos a los elementos recién creados
        newRow.querySelector('.producto-select').addEventListener('change', function() {
            updatePrecioUnitario(this);
        });

        newRow.querySelector('.cantidad-input').addEventListener('input', function() {
            updateTotal();
        });

        newRow.querySelector('.boton-cancelar').addEventListener('click', function() {
            eliminarFila(this);
        });

        // Inicializar el precio unitario y el total
        updatePrecioUnitario(newRow.querySelector('.producto-select'));
        updateTotal();
    }

    // Función para eliminar una fila
    function eliminarFila(button) {
        const row = button.closest('tr');
        const detallePedidoId = row.querySelector('[name="detalle_pedido_id[]"]').value;
        if (detallePedidoId !== '0') {
            const existingIds = eliminarDetalleInput.value ? eliminarDetalleInput.value.split(',') : [];
            existingIds.push(detallePedidoId);
            eliminarDetalleInput.value = existingIds.join(',');
        }
        row.remove();
        updateTotal();
    }

    agregarFilaButton.addEventListener('click', agregarFila);

    // Inicializar eventos en el DOM cargado
    document.querySelectorAll('.producto-select').forEach(select => {
        select.addEventListener('change', function() {
            updatePrecioUnitario(this);
        });
    });

    document.querySelectorAll('.cantidad-input').forEach(input => {
        input.addEventListener('input', function() {
            updateTotal();
        });
    });

    document.querySelectorAll('.boton-cancelar').forEach(button => {
        button.addEventListener('click', function() {
            eliminarFila(this);
        });
    });

    updateTotal(); // Calcular el total inicial
});
