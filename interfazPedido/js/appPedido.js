let carrito = [];
let carritoFinal = [];
let idCounter = 0; 
let isEdit = false;
let productos = [];
let cantidad = 1;

const agregadosProducts = []; // Declarado fuera del fetch
// extraer elementos del archivo jsn
const preloader = document.querySelector("[data-preaload]");

fetch('productos.json')
    .then(response => response.json())
    .then(data => {
        console.log('Datos cargados correctamente');
        productos = data;

        const sanguchesContainer = document.getElementById('sanguches-container');
        const salchipapasContainer = document.getElementById('salchipapas-container');
        const choripapasContainer = document.getElementById('choripapas-container');
        const parrilladasContainer = document.getElementById('parrilladas-container');
        const refrescosContainer = document.getElementById('refrescos-container');
        const infusionesContainer = document.getElementById('infusiones-container');
        const tomarContainer = document.getElementById('tomar-container');

        // filtrar productos apor categoría 1 (sandwiches) y 2 (salchipapas)
        const sanguches = data.filter(producto => parseInt(producto.categoria) === 1);
        const salchipapas = data.filter(producto => parseInt(producto.categoria) === 2);
        const choripapas = data.filter(producto => parseInt(producto.categoria) === 3);
        const parrilladas = data.filter(producto => parseInt(producto.categoria) === 4);
        const refrescos = data.filter(producto => parseInt(producto.categoria) === 5);
        const infusiones = data.filter(producto => parseInt(producto.categoria) === 6);
        const tomar = data.filter(producto => parseInt(producto.categoria) === 7);
        const agregados = data.filter(producto => parseInt(producto.categoria) === 8);
        agregadosProducts.push(...agregados);
        console.log(agregadosProducts, 'estos son los agregados')

        //estructura HTML 
        sanguches.forEach(producto => {
            const productoElement = createProductElement(producto);
            sanguchesContainer.appendChild(productoElement);
        });
  
        salchipapas.forEach(producto => {
            const productoElement = createProductElement(producto);
            salchipapasContainer.appendChild(productoElement);
        });

        choripapas.forEach(producto => {
            const productoElement = createProductElement(producto);
            choripapasContainer.appendChild(productoElement);
        });

        parrilladas.forEach(producto => {
            const productoElement = createProductElement(producto);
            parrilladasContainer.appendChild(productoElement);
        });

        refrescos.forEach(producto => {
            const productoElement = createProductElement(producto);
            refrescosContainer.appendChild(productoElement);
        });

        infusiones.forEach(producto => {
            const productoElement = createProductElement(producto);
            infusionesContainer.appendChild(productoElement);
        });

        tomar.forEach(producto => {
            const productoElement = createProductElement(producto);
            tomarContainer.appendChild(productoElement);
        });

        //abrir la ventana modal
        const allProducts = document.querySelectorAll('.producto');
        allProducts.forEach(producto => {
            producto.addEventListener('click', () => {
                console.log('Clic en producto');
                const productName = producto.querySelector('.producto-nombre').innerText;
                const existingProduct = carrito.find(item => {
                    return item.name === productName && JSON.stringify(item.add) === JSON.stringify(agregadosProducts);
                });
                console.log('existe?', existingProduct)
        
                if (existingProduct) {
                    console.log('hola')
                    editCart(existingProduct); // Llama a editCart si el producto ya está en el carrito
                    // Cambia el texto del botón a "Actualizar en el carrito"
                    addToCartButton.textContent = "Actualizar en el carrito";
                    // Cambia el evento clic del botón para que llame a la función para actualizar en el carrito

                } else {
                    openModal(producto);
                    // Si el producto no está en el carrito, restaura el texto y el evento del botón "Añadir al carrito"
                    addToCartButton.textContent = "Añadir al carrito";
                }
            });
        });

        const addToCartButton = document.getElementById('addToCartButton');
        addToCartButton.addEventListener('click', () => {
            addToCart();
        });

        document.getElementById('modal').addEventListener('click', (event) => {
            // cierra el modal si el clic ocurrió fuera de
                if (event.target === document.getElementById('modal')) {
                    closeModal();
                    }
                }); 

        var dropdownContent = document.getElementById("ingredientesMenu");
        agregadosProducts.forEach(agregado => {
            var checkboxWrapper = document.createElement("div");
            checkboxWrapper.classList.add("checkbox-wrapper");
    
            var checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.id = agregado.nombre.toLowerCase(); // Asignar un ID basado en el nombre del agregado
            checkbox.value = agregado.nombre;
    
            var label = document.createElement("label");
            label.htmlFor = checkbox.id;
            label.textContent = agregado.nombre;
    
            var priceSpan = document.createElement("span");
            priceSpan.textContent = "- S/. " + (parseFloat(agregado.precio) || 0).toFixed(2);
    
            // Agregar los elementos al div de contenedor
            checkboxWrapper.appendChild(checkbox);
            checkboxWrapper.appendChild(label);
            checkboxWrapper.appendChild(priceSpan);
        
            checkboxWrapper.addEventListener('click', function(event) {
                if (event.target !== checkbox && event.target !== label) {
                    checkbox.checked = !checkbox.checked;
                }
                handleCheckboxChange();
            });
    
            dropdownContent.appendChild(checkboxWrapper);
        });

         // Obtener todos los checkboxes de ingredientes adicionales
        const checkboxes = document.querySelectorAll('#ingredientesMenu input[type="checkbox"]');

        // Agregar el evento a cada checkbox
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', handleCheckboxChange);
        });

        function handleCheckboxChange() {
            updateTotalPrice(parseInt(document.getElementById('modal-quantity').innerText));
        }

        preloader.classList.add("loaded");
        document.body.classList.add("loaded");

        })

    .catch(error => {
        console.error('Error al cargar el archivo JSON', error);
        preloader.classList.add("loaded");
        document.body.classList.add("loaded");
    });

// funcion para crear el producto

    function createProductElement(producto) {
        const productoElement = document.createElement('div');
        productoElement.className = 'producto';
        productoElement.dataset.id = producto.idProducto; // Usar idProducto como el ID único
        productoElement.dataset.categoria = producto.categoria; // Usar idProducto como el ID único
        productoElement.innerHTML = `
            <img src="${producto.imagen}" alt="${producto.nombre}" class="producto-imagen">
            <h3 class="producto-nombre">${producto.nombre}</h3>
            <p class="producto-precio">S/. ${producto.precio}</p>
        `;
        return productoElement;
        }
  
    function openModal(producto) {
        const productId = producto.dataset.id; // Obtener el ID único del producto
        document.getElementById('modal-img').src = producto.querySelector('.producto-imagen').src;
        const productPriceText = producto.querySelector('.producto-precio').innerText;
        initialProductPrice = parseFloat(productPriceText.replace('S/. ', '')); // Almacenar el precio inicial
        document.getElementById('modal-name').innerText = producto.querySelector('.producto-nombre').innerText;
        document.getElementById('modal-price').innerText = producto.querySelector('.producto-precio').innerText;
        document.getElementById('modal-quantity').innerText = 1;
        document.getElementById('indicaciones-especiales').value = '';
        document.getElementById('modal').dataset.productId = productId; // Asignar el ID único del producto al modal
        
        const categoria = parseInt(producto.dataset.categoria);
        const ingredientesAdicionales = document.querySelector('.ingredientes-adicionales');
        if (categoria !== 5 && categoria !== 6 && categoria !== 7) {
            ingredientesAdicionales.style.display = 'block'; // Mostrar la sección
        } else {
            ingredientesAdicionales.style.display = 'none'; // Ocultar la sección
        }
    
        // Deseleccionar todos los checkboxes de ingredientes adicionales
        const checkboxes = document.querySelectorAll('#ingredientesMenu input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        document.getElementById('modal').style.display = 'block';
        document.body.classList.add('modal-open');
        document.body.classList.add('modal-product-open');

        
        console.log('id', producto.dataset.id);
        console.log('cat',categoria)

        hiddenBar(); 
    }

    function openModalWith(producto, precio, quantity, notes, selectedAgregados) {
        const productId = producto.dataset.id; // Obtener el ID único del producto
        const productPriceText = producto.querySelector('.producto-precio').innerText;
        initialProductPrice = parseFloat(productPriceText.replace('S/. ', '')); // Almacenar el precio inicial
        document.getElementById('modal-img').src = producto.querySelector('.producto-imagen').src;
        document.getElementById('modal-name').innerText = producto.querySelector('.producto-nombre').innerText;
        document.getElementById('modal-price').innerText = `S/. ${precio.toFixed(2)}`;
        document.getElementById('modal-quantity').innerText = quantity; // Usar la cantidad pasada como parámetro
        document.getElementById('indicaciones-especiales').value = notes; // Usar las notas pasadas como parámetro
        document.getElementById('modal').dataset.productId = productId; // Asignar el ID único del producto al modal
        
        const categoria = parseInt(producto.dataset.categoria);
        const ingredientesAdicionales = document.querySelector('.ingredientes-adicionales');
        if (categoria !== 5 && categoria !== 6 && categoria !== 7) {
            ingredientesAdicionales.style.display = 'block'; // Mostrar la sección
        } else {
            ingredientesAdicionales.style.display = 'none'; // Ocultar la sección
        }

        // Deseleccionar todos los elementos del menú desplegable
        const checkboxes = document.querySelectorAll('#ingredientesMenu input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    
        // Seleccionar los agregados pasados como parámetro
        selectedAgregados.forEach(agregado => {
            const checkbox = document.querySelector(`#ingredientesMenu input[type="checkbox"][value="${agregado}"]`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    
        document.getElementById('modal').style.display = 'block';
        document.body.classList.add('modal-open');
        document.body.classList.add('modal-product-open');
        
        hiddenBar(); 
    }



    function closeModal() {
        document.body.classList.remove('modal-open');
        document.body.classList.remove('modal-product-open');

        document.getElementById('modal').style.display = 'none';
        hiddenBar(); // Aplica la función para controlar el overflow
    }
    
    // para que se esconda la barra de desplazamiento
    function hiddenBar() {
            const body = document.body;
            const html = document.documentElement;
    
            if (body.classList.contains('modal-open')) {
                html.style.overflow = 'hidden';
            } else {
                html.style.overflow = 'auto';
            }
    }
    
    //funciones dentro del modal
    
    function updateTotalPrice(quantity) {
        let newTotal = initialProductPrice * quantity; // Calcular el nuevo total basado en el precio inicial
        
        // Obtener todos los checkboxes de ingredientes adicionales
        const checkboxes = document.querySelectorAll('#ingredientesMenu input[type="checkbox"]');
        
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                // Obtener el nombre del agregado seleccionado
                const addedName = checkbox.value;
                // Buscar el agregado en la lista de agregados con ese nombre
                const added = agregadosProducts.find(agregado => agregado.nombre === addedName);
                if (added) {
                    // Sumar el costo del agregado al nuevo total
                    newTotal += parseFloat(added.precio) * quantity;
                }
            }
        });
    
        // Actualizar el precio en el modal
        document.getElementById('modal-price').innerText = `S/. ${newTotal.toFixed(2)}`;
    }
    
    
    
    function decreaseQuantity() {
        const quantityElement = document.getElementById('modal-quantity');
        let quantity = parseInt(quantityElement.innerText);
        if (quantity > 1) {
            quantity--;
            quantityElement.innerText = quantity;
            cantidad=quantity;
            updateTotalPrice(quantity); // Llamar a la función para actualizar el precio
        }
    }
    
    function increaseQuantity() {
        const quantityElement = document.getElementById('modal-quantity');
        let quantity = parseInt(quantityElement.innerText);
        quantity++;
        quantityElement.innerText = quantity;
        cantidad=quantity;
        updateTotalPrice(quantity); // Llamar a la función para actualizar el precio
    }
    
        function calcularPrecioEnviar(agregadosSeleccionados, quantity, totalPrice) {
            let totalAgregadosCost = 0;
        
            // Calcular el costo total de los agregados seleccionados
            agregadosSeleccionados.forEach(agregadoSeleccionado => {
                // Buscar el agregado seleccionado en el arreglo agregadosProducts
                const agregado = agregadosProducts.find(agregado => agregado.nombre === agregadoSeleccionado);
                if (agregado) {
                    totalAgregadosCost += parseFloat(agregado.precio);
                }
            });
        
            // Restar el costo total de los agregados al precio total
            const totalWithoutAgregados = totalPrice - (totalAgregadosCost*quantity);
        
            // Calcular el precio unitario dividiendo el precio total sin los agregados entre la cantidad
            const unitPrice = totalWithoutAgregados / quantity;
            console.log('precio unitario', unitPrice)
            return unitPrice.toFixed(2); // Redondear el precio unitario a 2 decimales y devolverlo como una cadena
        }
        
    
    
    function enviarPedido() {

        const carritoFinal = carrito.slice(); // Hacer una copia superficial de carrito

        // Crear objeto principal del pedido
        const pedido = {
            Estado: 1,
            Fecha: obtenerFechaActual(), // Esta función debería retornar la fecha actual en el formato requerido
            FechaAprobacion: null,
            Cliente_idCliente: null,
            Mesa_id: m !== null ? parseInt(m, 10) : null,
            Usuario_id: null,
            TipoPedido_id: 1,
            MedioPago_id: null,
            fechaCocinando:null,
            fechaTerminado:null,
            detalles: []
        };
        console.log(carritoFinal);
        // Iterar sobre el carrito final y agregar detalles al pedido
        carritoFinal.forEach(item => {
            const detalle = {
                Fecha: obtenerFechaActual(), // Fecha del detalle
                Precio: calcularPrecioEnviar(item.add, item.quantity, item.price), // Precio del producto
                Cantidad: item.quantity, // Cantidad del producto
                NotaPedido: item.notes, // Notas del producto
                Producto_id: item.id // ID del producto
            };
            pedido.detalles.push(detalle);
        });
        // Convertir el objeto pedido a JSON

        console.log(pedido)
        const jsonPedido = JSON.stringify(pedido);
        console.log(jsonPedido);

        crearSolicitudPedido(jsonPedido);
    }
    
    
    // Función para obtener la fecha actual en el formato requerido (YYYY-MM-DD)
    function obtenerFechaActual() {
        const hoy = new Date();
        const dia = String(hoy.getDate()).padStart(2, '0');
        const mes = String(hoy.getMonth() + 1).padStart(2, '0');
        const ano = hoy.getFullYear();
        const hora = String(hoy.getHours()).padStart(2, '0');
        const minutos = String(hoy.getMinutes()).padStart(2, '0');
        const segundos = String(hoy.getSeconds()).padStart(2, '0');
        return `${ano}-${mes}-${dia} ${hora}:${minutos}:${segundos}`;
    }


   
    function crearSolicitudCliente(jsonPedido) {
        return fetch('../src/controllers/insertarCliente.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: jsonPedido
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('JSON Cliente enviado satisfactoriamente. ID del Cliente:', data.idCliente);
                return data.idCliente; // Retornar el idCliente
            } else {
                console.error('Error en el envío del JSON:', data.message);
                throw new Error('Error al crear cliente');
            }
        })
        .catch(error => {
            console.error('Error en el fetch:', error);
            throw error;
        });
    }
    

    function crearSolicitudPedido(jsonPedido) {
        fetch('../src/controllers/pedido_detalle_pedido.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: jsonPedido
        })
        .then(response => {
            if (response.ok) {
                reiniciarPrecio();
                console.log('JSON enviado satisfactoriamente.');
            } else {
                console.error('Error en el envío del JSON:', response.statusText);
            }
        })
        .catch(error => {
            console.error('Error en el fetch:', error);
            console.log('JSON enviado:', jsonPedido);
        });
    }
    

    
  // Guardar el carrito en sessionStorage
//sessionStorage.setItem('carrito', JSON.stringify(carrito));
async function enviarPedidoLlevar() {
    let clienteId = null;
    let nombre = document.getElementById("customer-name").value;
    const cliente = {
        Nombre: nombre,
        Direccion: null,
        NumTelefono: null
    }
    const jsonCliente = JSON.stringify(cliente);
    console.log(jsonCliente);

    try {
        // Esperar a que la función crearSolicitudCliente retorne el idCliente
        clienteId = await crearSolicitudCliente(jsonCliente);
        console.log(clienteId);

        const carritoFinal = carrito.slice(); // Hacer una copia superficial de carrito

        // Crear objeto principal del pedido
        const pedido = {
            Estado: 1,
            Fecha: obtenerFechaActual(), // Esta función debería retornar la fecha actual en el formato requerido
            Cliente_idCliente: clienteId,
            Mesa_id: 21,
            Usuario_id: null,
            TipoPedido_id: 2,
            MedioPago_id: null,
            detalles: []
        };
        console.log(carritoFinal);

        // Iterar sobre el carrito final y agregar detalles al pedido
        carritoFinal.forEach(item => {
            const detalle = {
                Fecha: obtenerFechaActual(), // Fecha del detalle
                Precio: calcularPrecioEnviar(item.add, item.quantity, item.price), // Precio del producto
                Cantidad: item.quantity, // Cantidad del producto
                NotaPedido: item.notes, // Notas del producto
                Producto_id: item.id // ID del producto
            };
            pedido.detalles.push(detalle);
        });

        // Convertir el objeto pedido a JSON
        console.log(pedido);
        const jsonPedido = JSON.stringify(pedido);
        console.log(jsonPedido);

        crearSolicitudPedido(jsonPedido);

    } catch (error) {
        console.error('Error en la creación del cliente y envío del pedido:', error);
    }
}

document.getElementById("pagoForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    // Obtener valores de los campos del formulario
    let fullName = document.getElementById("fullName").value;
    let email = document.getElementById("email").value;
    let phoneNumber = document.getElementById("phoneNumber").value;
    let address = document.getElementById("address").value;

    // Obtener el método de pago seleccionado
    let paymentMethod;
    if (document.getElementById("contraentrega").checked) {
        paymentMethod = 1;
    } else if (document.getElementById("yape").checked) {
        paymentMethod = 2;
    } else if (document.getElementById("plin").checked) {
        paymentMethod = 3;
    }

    // Obtener el código de transacción si se eligió Yape o Plin
    let transactionCode;
    if (paymentMethod === 2) {
        transactionCode = document.getElementById("codigoYape").value;
    } else if (paymentMethod === 3) {
        transactionCode = document.getElementById("codigoPlin").value;
    }

    console.log('codigoo', transactionCode);
    // Crear un objeto con todos los datos
    let formData = {
        fullName: fullName,
        email: email,
        phoneNumber: phoneNumber,
        address: address,
        paymentMethod: paymentMethod,
        transactionCode: transactionCode
    };

    console.log("aqui?",formData);
    enviarPedidoDelivery(fullName,address,phoneNumber,paymentMethod, transactionCode)
    console.log("pedido enviado exitosamente");


});


async function enviarPedidoDelivery(Nombre, direccion, telefono, metodopago, codigotrans) {
    // Verificar que todos los campos estén llenos
    if (!Nombre || !direccion || !telefono || !metodopago ) {
        console.error("Por favor, complete todos los campos antes de enviar el pedido.");
        
        // Mostrar el mensaje de error en la interfaz
        document.getElementById("error-message").textContent = "Complete todos los campos antes de enviar.";
        document.getElementById("error-message").style.display = "block";
        
        return; // No hacer nada más si falta algún campo
    }
    
    // Verificar si se seleccionó Yape o Plin y asegurarse de que se haya proporcionado un código de transacción
    if ((metodopago === 2 && !document.getElementById("codigoYape").value) || (metodopago === 3 && !document.getElementById("codigoPlin").value)) {
        console.error("Por favor, complete el código de transacción.");
        
        // Mostrar el mensaje de error en la interfaz
        document.getElementById("error-message").textContent = "Complete el código de transacción.";
        document.getElementById("error-message").style.display = "block";
        
        return; // No hacer nada más si falta el código de transacción
    }

    // Si todos los campos están llenos, ocultar el mensaje de error en la interfaz
    document.getElementById("error-message").style.display = "none";

    let clienteId = null;
    const cliente = {
        Nombre: Nombre,
        Direccion: direccion,
        NumTelefono: telefono
    }
    const jsonCliente = JSON.stringify(cliente);
    console.log(jsonCliente);

    try {
        // Esperar a que la función crearSolicitudCliente retorne el idCliente
        clienteId = await crearSolicitudCliente(jsonCliente);
        console.log(clienteId);
        carritoPrepared();

        const carritoFinal = carrito.slice(); // Hacer una copia superficial de carrito

        // Crear objeto principal del pedido
        const pedido = {
            Estado: 1,
            Fecha: obtenerFechaActual(), // retorna fecha actual
            Cliente_idCliente: clienteId,
            Mesa_id: 22,
            Usuario_id: null,
            TipoPedido_id: 3,
            MedioPago_id: metodopago,
            codTrans:codigotrans,
            detalles: []
        };
        console.log(carritoFinal);

        // Iterar sobre el carrito final y agregar detalles al pedido
        carritoFinal.forEach(item => {
            const detalle = {
                Fecha: obtenerFechaActual(), // Fecha del detalle
                Precio: calcularPrecioEnviar(item.add, item.quantity, item.price), // Precio del producto
                Cantidad: item.quantity, // Cantidad del producto
                NotaPedido: item.notes, // Notas del producto
                Producto_id: item.id // ID del producto
            };
            pedido.detalles.push(detalle);
        });

        // Convertir el objeto pedido a JSON
        console.log(pedido);
        const jsonPedido = JSON.stringify(pedido);
        console.log(jsonPedido);

        crearSolicitudPedido(jsonPedido);
        _showModal('modal-confirmed');
        closeSidebar();
        closePagoModal();

    } catch (error) {
        console.error('Error en la creación del cliente y envío del pedido:', error);
    }
}


