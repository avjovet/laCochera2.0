let carrito = [];
let carritoFinal = [];
let idCounter = 0; 
let isEdit = false;
// extraer elementos del archivo jsn
fetch('productos.php')
    .then(response => response.json())
    .then(data => {
        console.log('Datos cargados correctamente');
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
                openModal(producto);
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
        })
        
    .catch(error => console.error('Error al cargar el archivo JSON', error));

  
// funcion para crear el producto

    function createProductElement(producto) {
        const productoElement = document.createElement('div');
        productoElement.className = 'producto';
        productoElement.dataset.id = producto.idProducto; // Usar idProducto como el ID único
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
        document.getElementById('modal-name').innerText = producto.querySelector('.producto-nombre').innerText;
        document.getElementById('modal-price').innerText = producto.querySelector('.producto-precio').innerText;
        document.getElementById('modal-quantity').innerText = 1;
        document.getElementById('indicaciones-especiales').value = '';
        document.getElementById('modal').dataset.productId = productId; // Asignar el ID único del producto al modal

        document.getElementById('modal').style.display = 'block';
        document.body.classList.add('modal-open');
        document.body.classList.add('modal-product-open');

        
        console.log('id', producto.dataset.id);
        hiddenBar(); 
    }
  




    function closeModal() {
        document.body.classList.remove('modal-open');
        document.body.classList.add('modal-product-open');

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
    
    function decreaseQuantity() {
        const quantityElement = document.getElementById('modal-quantity');
        let quantity = parseInt(quantityElement.innerText);
        if (quantity > 1) {
            quantity--;
            quantityElement.innerText = quantity;
        }
    }
    
    function increaseQuantity() {
        const quantityElement = document.getElementById('modal-quantity');
        let quantity = parseInt(quantityElement.innerText);
        quantity++;
        quantityElement.innerText = quantity;
    }
    
    
    function addToCart() {
        const productId = parseInt(document.getElementById('modal').dataset.productId); // Obtener el ID único del producto desde el modal
        const productName = document.getElementById('modal-name').innerText;
        const productPrice = parseFloat(document.getElementById('modal-price').innerText.replace('S/. ', ''));
        const productQuantity = parseInt(document.getElementById('modal-quantity').innerText);
        const notes = document.getElementById('indicaciones-especiales').value;
        const productTotal = productPrice * productQuantity;
    
        // busca el índice del producto en el carrito
        const existingProductIndex = carrito.findIndex(item => item.name === productName);
    
        // si producto ya existe en el carrito, actualizar sus propiedades
        if (existingProductIndex !== -1) {
            carrito[existingProductIndex].price = productPrice;
            if(isEdit==true){
                console.log(isEdit)
                carrito[existingProductIndex].quantity = productQuantity; 
    
                isEdit=false;
            }else{
                console.log("isedit",isEdit)
    
                carrito[existingProductIndex].quantity += productQuantity; 
    
            }
            carrito[existingProductIndex].notes = notes; // Actualizar las notas
            carrito[existingProductIndex].total =  carrito[existingProductIndex].quantity*productPrice; // Actualizar el total
            carrito[existingProductIndex].id =  productId; // Actualizar el total
    
    
        } else {
            console.log('id', productId);
    
            // Si no existe, agregar el nuevo producto al carrito
            carrito.push({
                id:productId,
                name: productName,
                price: productPrice,
                quantity: productQuantity,
                notes: notes,
                total: productTotal
            });
        }
    
        console.log('Producto añadido al carrito:', carrito);
    
        updatePrice();
        updateCart();
        closeModal();
    }
    
    function updatePrice() {
        const totalCarrito = carrito.reduce((total, producto) => total + producto.total, 0);
    
        const priceElement = document.querySelector('.price');
        priceElement.innerText = `S/. ${totalCarrito.toFixed(2)}`;
    }
    
    const reiniciarButton = document.querySelector('.reiniciar');
    reiniciarButton.addEventListener('click', () => {
        reiniciarPrecio();
    });
    
    function reiniciarPrecio() {
        carrito = [];
        
        // Actualizar la visualización del precio en la interfaz
        updatePrice();
        updateCart();
    }
    
    function mostrarCarrito() {
        console.log(carrito);
    
        var cartSidebar = document.getElementById("cart-sidebar"); // obtener la barra lateral del carrito
        cartSidebar.style.display = "block"; // mostrar la barra lateral del carrito
    }
    
    function closeSidebar() {
        var cartSidebar = document.getElementById("cart-sidebar");
        cartSidebar.style.display = "none";
    }
    
    function updateCart() {
        var cartContainer = document.getElementById("cart-items");
        cartContainer.innerHTML = ""; // limpiar contenido anterior
    
        carrito.forEach((item, index) => {
            var cartItemDiv = document.createElement("div");
            cartItemDiv.classList.add("cart-item");
            
            // fila 1: cantidad nombre y precio
            var row1Div = document.createElement("div");
            row1Div.classList.add("row");
            row1Div.style.display = "flex"; 
            row1Div.style.justifyContent = "space-between"; 
    
            var quantitySpan = document.createElement("span");
            quantitySpan.textContent = item.quantity + " ";
            quantitySpan.classList.add("cart-quantity", "cart-label");
            row1Div.appendChild(quantitySpan);
    
            var nameSpan = document.createElement("span");
            nameSpan.textContent = item.name;
            nameSpan.classList.add("cart-product-name", "cart-label"); 
            row1Div.appendChild(nameSpan);
    
            var priceSpan = document.createElement("span");
            priceSpan.textContent = "S/. " + item.total.toFixed(2);
            priceSpan.classList.add("cart-price", "cart-label"); 
            row1Div.appendChild(priceSpan);
    
            cartItemDiv.appendChild(row1Div);
    
            // fila 2:  indicaciones
            var row2Div = document.createElement("div");
            row2Div.classList.add("row");
            var notesSpan = document.createElement("span");
            notesSpan.textContent = "Notas: " + item.notes;
            notesSpan.classList.add("cart-notes");
            row2Div.appendChild(notesSpan);
            cartItemDiv.appendChild(row2Div);
    
            // fila 3: botones de editar y eliminar
            var row3Div = document.createElement("div");
            row3Div.classList.add("row", "button-row");
    
            var editButton = document.createElement("button");
            editButton.classList.add("cart-edit-button");
            var editIcon = document.createElement("i");
            editIcon.classList.add("fas", "fa-edit"); 
            editButton.appendChild(editIcon);
            row3Div.appendChild(editButton);
    
            var deleteButton = document.createElement("button");
            deleteButton.classList.add("cart-delete-button");
            var deleteIcon = document.createElement("i");
            deleteIcon.classList.add("fas", "fa-trash-alt");
            deleteButton.appendChild(deleteIcon);
            row3Div.appendChild(deleteButton);
    
            cartItemDiv.appendChild(row3Div);
    
            cartContainer.appendChild(cartItemDiv);
    
            //eliminar
            deleteButton.addEventListener('click', () => {
                carrito.splice(index, 1);
                updateCart();
            });
    
            //editar
            editButton.addEventListener('click', () => {
                isEdit=true;
                console.log("VOLVIENDO TRUE", isEdit)
                editCart(item);
            });
            
        });
    
        const totalCarrito = carrito.reduce((total, producto) => total + producto.total, 0);
    
        const totalTextElement = document.getElementById("total-text");
        totalTextElement.innerText = `Total: S/. ${totalCarrito.toFixed(2)}`;
    
        updatePrice();
    }
    
    function editCart(item) {
        const allProducts = document.querySelectorAll('.producto');
        let productoDeseado;
        
        allProducts.forEach((producto, index) => {
            const nombreProducto = producto.querySelector('.producto-nombre').innerText;
    
            if (nombreProducto === item.name) {
                productoDeseado = producto;
            }
        });
        
        if (productoDeseado) {
            openModal(productoDeseado);
        } else {
            console.log('No se encontró ningún producto con el nombre deseado.');
        }
    }
    
    
   
    function enviarPedido() {

        const carritoFinal = carrito.slice(); // Hacer una copia superficial de carrito

        // Crear objeto principal del pedido
        const pedido = {
            Estado: 1,
            Fecha: obtenerFechaActual(), // Esta función debería retornar la fecha actual en el formato requerido
            Cliente_idCliente: null,
            Mesa_id: null,
            Usuario_id: null,
            TipoPedido_id: 12,
            MedioPago_id: null,
            detalles: []
        };
        console.log(carritoFinal);
        // Iterar sobre el carrito final y agregar detalles al pedido
        carritoFinal.forEach(item => {
            const detalle = {
                Fecha: obtenerFechaActual(), // Fecha del detalle
                Precio: item.price, // Precio del producto
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

        // Aquí puedes hacer lo que necesites con el JSON del pedido, por ejemplo, enviarlo al backend
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
        fetch('/interfazPedido/src/controllers/insertarCliente.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: jsonPedido
        })
        .then(response => {
            if (response.ok) {
                console.log('JSON Cliente enviado satisfactoriamente.');
            } else {
                console.error('Error en el envío del JSON:', response.statusText);
            }
        })
        .catch(error => {
            console.error('Error en el fetch:', error);
            console.log('JSON enviado:', jsonPedido);
        });
    }

    function crearSolicitudPedido(jsonPedido) {
        fetch('/interfazPedido/src/controllers/pedido_detalle_pedido.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: jsonPedido
        })
        .then(response => {
            if (response.ok) {
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
function enviarPedidoLlevar() {

    //let nombre = document.getElementById("customer-name").value;
    let nombre = document.getElementById("customer-name").value;
    const cliente = {
        Nombre: nombre,
        Direccion: null,
        NumTelefono: null
    }
    const jsonCliente = JSON.stringify(cliente);
    console.log(jsonCliente);
    crearSolicitudCliente(jsonCliente);


    const carritoFinal = carrito.slice(); // Hacer una copia superficial de carrito

    // Crear objeto principal del pedido
    const pedido = {
        Estado: 1,
        Fecha: obtenerFechaActual(), // Esta función debería retornar la fecha actual en el formato requerido
        Cliente_idCliente: null,
        Mesa_id: null,
        Usuario_id: null,
        TipoPedido_id: 12,
        MedioPago_id: null,
        detalles: []
    };
    console.log(carritoFinal);
    // Iterar sobre el carrito final y agregar detalles al pedido
    carritoFinal.forEach(item => {
        const detalle = {
            Fecha: obtenerFechaActual(), // Fecha del detalle
            Precio: item.price, // Precio del producto
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

    // Aquí puedes hacer lo que necesites con el JSON del pedido, por ejemplo, enviarlo al backend
    crearSolicitudPedido(jsonPedido);
}

