let filtroDataAdded = false; // Bandera para indicar si se ha agregado el evento de filtrado

document.addEventListener('DOMContentLoaded', function() {
    setupEventListeners();
    initializePage();
});




function setupEventListeners() {
    document.getElementById('btnAgregar').addEventListener('click', toggleFormVisibility);
    document.getElementById('formProducto').addEventListener('submit', handleFormSubmit);
    document.getElementById('previousPage').addEventListener('click', goToPreviousPage);
    document.getElementById('nextPage').addEventListener('click', goToNextPage);
    document.getElementById('itemsPerPage').addEventListener('change', handleItemsPerPageChange);
    document.querySelector('.form-control').addEventListener('input', handleSearchInput);
}

function toggleFormVisibility() {
    document.getElementById('formularioProducto').classList.toggle('mostrar');
}

function handleFormSubmit(event) {
    event.preventDefault();
    const producto = getFormData();
    enviarProducto(producto);
    vaciarFormulario();
}

function vaciarFormulario() {
    document.getElementById('formProducto').reset();
}

function getFormData() {
    return {
        nombre: document.getElementById('autoSizingInputnombre').value,
        
    };
}

function enviarProducto(producto) {
    const searchTerm = document.querySelector('.form-control');
    const originalSearchTerm = searchTerm.value.trim().toLowerCase();
    console.log(JSON.stringify(producto));
    fetch('../src/controllers/AdminPanel/ManejoCategoria.php?action=insertar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(producto)
    })
    .then(response => {
        if (response.ok) {
            console.log('Producto agregado correctamente.');
            alert("Producto agregado")
            actualizarTabla();
            
            // Vaciar la barra de búsqueda después de agregar un producto
            searchTerm.value = '';
        } else {
            response.json().then(error => {
                console.error('Error al agregar el producto:', error.message);
            });
        }
    })
    .catch(handleError);
}


function handleResponse(response) {
    if (response.ok) {
        console.log('Producto agregado correctamente.');
        actualizarTabla();
    } else {
        response.json().then(error => {
            console.error('Error al agregar el producto:', error.message);
        });
    }
}

function handleError(error) {
    console.error('Error en la solicitud:', error);
}

function initializePage() {
    const itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
    obtenerProductos(1, itemsPerPage);
}

function goToPreviousPage() {
    const currentPage = parseInt(document.getElementById('currentPage').textContent);
    if (currentPage > 1) {
        const itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
        obtenerProductos(currentPage - 1, itemsPerPage);
    }
}

function goToNextPage() {
    const currentPage = parseInt(document.getElementById('currentPage').textContent);
    const totalPages = parseInt(document.getElementById('totalPages').textContent);
    if (currentPage < totalPages) {
        const itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
        obtenerProductos(currentPage + 1, itemsPerPage);
    }
}

function handleItemsPerPageChange() {
    obtenerProductos(1, parseInt(this.value));
}

function handleSearchInput() {
    const searchTerm = this.value.trim().toLowerCase();
    if (searchTerm === '') {
        const itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
        obtenerProductos(1, itemsPerPage);
    } else {
        fetch(`categoria.php?search=${searchTerm}`)
            .then(response => response.json())
            .then(data => mostrarProductosFiltrados(data, searchTerm));
    }
}

function mostrarProductosFiltrados(data, searchTerm) {
    
    const productosFiltrados = data.filter(producto => producto.NombreCategoria.toLowerCase().includes(searchTerm));
    const tabla = document.getElementById('contenidoTabla');
    tabla.innerHTML = productosFiltrados.length > 0 ? 
        productosFiltrados.map(producto => crearFilaProducto(producto)).join('') : 
        "<tr><td colspan='4'>No hay productos disponibles</td></tr>";
    agregarEventosEdicionYEliminacion();  // Agregar los event listeners después de actualizar la tabla
}

function obtenerProductos(page, itemsPerPage) {
    fetch(`categoria.php?page=${page}&itemsPerPage=${itemsPerPage}`)
        .then(response => response.json())
        .then(data => {
            actualizarTablaProductos(data, page, itemsPerPage, 0)
            ocultarLoader();
        })
        .catch(error => console.error('Error al obtener los productos:', error));
}

function ocultarLoader() {
    document.getElementById('loader').style.display = 'block';
    
}

function actualizarTablaProductos(data, page, itemsPerPage, centy) {
    const tabla = document.getElementById('contenidoTabla');
    tabla.innerHTML = data.length > 0 ? 
        data.slice((page - 1) * itemsPerPage, page * itemsPerPage).map(producto => crearFilaProducto(producto)).join('') : 
        "<tr><td colspan='4'>No hay productos disponibles</td></tr>";

    document.getElementById('currentPage').textContent = page;
    document.getElementById('totalPages').textContent = Math.ceil(data.length / itemsPerPage);
    if (!filtroDataAdded) { // Verificar si el evento de filtrado ya se ha agregado
        agregarEventosFiltrado(data);
        filtroDataAdded = true; // Cambiar la bandera a true después de agregar el evento
    }
    
    agregarEventosEdicionYEliminacion();
}

function crearFilaProducto(producto) {
    const accionOcultar = producto.Estado == 1 ? "Ocultar" : "Mostrar";
    const claseOculto = producto.Estado == 0 ? "producto-oculto" : "";
    
    return `
        <tr class="${claseOculto}">
            <td class="nombre">${producto.NombreCategoria}</td>
            <td class="centritoloco">
                <div class="dropdown">
                    <button class="dropbtn"><i class="fas fa-edit"></i></button>
                    <div class="dropdown-content">
                        <a href="#" class="editarproducto" data-id="${producto.idCategoriaProducto}">Editar</a>
                        <a href="#" class="eliminar-producto" data-id="${producto.idCategoriaProducto}">Eliminar</a>
                        <a href="#" class="ocultar-producto" data-id="${producto.idCategoriaProducto}">${accionOcultar}</a>
                    </div>
                </div>
            </td>
        </tr>
    `;
}


function agregarEventosFiltrado(data) {
    document.querySelectorAll('.thfiltro').forEach(th => {
        th.addEventListener('click', function(event) {
            event.preventDefault();
            ordenarProductos(th, data);
        });
    });
}

function ordenarProductos(th, data) {

    console.log(th.dataset.order);
    const field = th.getAttribute('data-field');
    const sortOrder = th.getAttribute('data-order');
    const newOrder = sortOrder === 'asc' ? 'desc' : 'asc';
    th.setAttribute('data-order', newOrder);
    console.log(th.dataset.order);
    data.sort((a, b) => {
        if (field === 'nombre') return newOrder === 'asc' ? a.NombreCategoria.localeCompare(b.NombreCategoria) : b.NombreCategoria.localeCompare(a.NombreCategoria);
        //return newOrder === 'asc' ? a[field] - b[field] : b[field] - a[field];
    });

    actualizarTablaProductos(data, parseInt(document.getElementById('currentPage').textContent), parseInt(document.getElementById('itemsPerPage').value),1);
}

function agregarEventosEdicionYEliminacion() {
    document.querySelectorAll('.eliminar-producto').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                eliminarProducto(this.getAttribute('data-id'));
            }

        });
    });

    document.querySelectorAll('.editarproducto').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            mostrarModalEdicion(this.getAttribute('data-id'));
        });
    


    });

    document.querySelectorAll('.ocultar-producto').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            ocultarProducto(this.getAttribute('data-id'));


        });
    

    });

    document.querySelector('.modal-content .close').addEventListener('click', cerrarModalEdicion);
    document.getElementById('formEditarProducto').addEventListener('submit', handleEditarProductoSubmit);
}

function mostrarModalEdicion(idProducto) {
    toggleSidebar();
    const modal = document.getElementById('myModal');
    modal.setAttribute('data-id', idProducto);
    modal.style.display = 'block';
}

function cerrarModalEdicion() {
    document.getElementById('myModal').style.display = 'none';
    toggleSidebar();
}

function handleEditarProductoSubmit(event) {
    event.preventDefault();
    const idProducto = document.getElementById('myModal').getAttribute('data-id');

    const productoEditado = {
        nombre: document.getElementById('autoSizingInputnombreEditar').value,
        
    };
    console.log(productoEditado);
    if (confirm('¿Estás seguro de que deseas editar este producto?')) {
        editarProducto(idProducto, productoEditado);
        cerrarModalEdicion();
    }
}

function toggleSidebar() {
    if (window.innerWidth > 991) {
        document.body.classList.toggle('sb-sidenav-toggled');
        localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
    }
}

function ocultarProducto(idProducto) {
    

    fetch(`../src/controllers/AdminPanel/ManejoCategoria.php?id=${idProducto}`, {
        method: 'OCULT',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.ok) {
            console.log('Producto ocultado correctamente.');
            actualizarTabla();

            
        } else {
            console.error('Error al ocultar el producto.');
        }
    })
    .catch(error => console.error('Error en la solicitud:', error));
}

function eliminarProducto(idProducto) {
    const searchTerm = document.querySelector('.form-control');
    const originalSearchTerm = searchTerm.value.trim().toLowerCase();

    fetch(`../src/controllers/AdminPanel/ManejoCategoria.php?id=${idProducto}`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (response.ok) {
            console.log('Producto eliminado correctamente.');
            actualizarTabla();
            searchTerm.value = '';
        } else {
            console.error('Error al eliminar el producto.');
        }
    })
    .catch(error => console.error('Error en la solicitud:', error));
}

function editarProducto(idProducto, datosProducto) {
    const searchTerm = document.querySelector('.form-control');
    const originalSearchTerm = searchTerm.value.trim().toLowerCase();
    console.log(idProducto);
    console.log(datosProducto);
    fetch(`../src/controllers/AdminPanel/ManejoCategoria.php?id=${idProducto}`, {
        method: 'EDIT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datosProducto)
    })
    .then(response => {
        if (response.ok) {
            console.log(JSON.stringify(datosProducto));
            console.log('Producto editado correctamente.');
            actualizarTabla();
            searchTerm.value = '';

            //aqui quiero realizar la busqueda del elemento que se encontraba en el buscador
        } else {
            console.error('Error al editar el producto.');
        }
    })
    .catch(error => console.error('Error en la solicitud:', error));
}

function actualizarTabla() {
    const itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
    const currentPage = parseInt(document.getElementById('currentPage').textContent);
    obtenerProductos(currentPage, itemsPerPage);
}







