let currentPosition = 0;
function addToCart() {
    console.log('cantidad', cantidad);
    console.log('estos son los productos', productos);
    const productId = parseInt(document.getElementById('modal').dataset.productId);

    // Buscar el producto en el arreglo global productos usando el idProducto
    const product = productos.find(prod => parseInt(prod.idProducto) === productId);
    
    // Extraer el nombre y el precio del producto encontrado
    const productName = product.nombre;
    const productPrice = parseFloat(product.precio); // Asegúrate de convertir el precio a número
    
    // Obtener la cantidad del producto del modal
    const productQuantity = parseInt(document.getElementById('modal-quantity').innerText);
    
    // Obtener las notas del modal
    const notes = document.getElementById('indicaciones-especiales').value;

    // Obtener los agregados seleccionados
    const selectedAdditions = [];
    const checkboxes = document.querySelectorAll('#ingredientesMenu input[type="checkbox"]:checked');
    checkboxes.forEach(checkbox => {
        selectedAdditions.push(checkbox.value);
    });

    // Calcular el precio total del producto incluyendo los agregados
    let totalPrice = productPrice;
    console.log('antes');

    selectedAdditions.forEach(addition => {
        console.log('comparando');
        const agregado = agregadosProducts.find(agregado => agregado.nombre === addition);

        if (agregado) {
            totalPrice += parseFloat(agregado.precio);
            console.log('tiene agregadoss')
        }
    });

    const existingProductIndex = carrito.findIndex(item => {
        return item.name === productName && JSON.stringify(item.add) === JSON.stringify(selectedAdditions);
    });
    
    console.log('existeeee O NO', existingProductIndex);
    console.log('editando', isEdit);

    if (existingProductIndex !== -1 || isEdit) {
        console.log('existeeee', existingProductIndex);
        console.log('indexx', existingProductIndex);
        
        if (isEdit) {
            const existingProduct = carrito.find(item => item.id === productId);
            if (existingProduct) {
                console.log('el precio es', totalPrice);

                existingProduct.price = totalPrice*productQuantity;
                existingProduct.quantity = productQuantity; 
                existingProduct.notes = notes;
                existingProduct.total = totalPrice;
                existingProduct.add = selectedAdditions;
            }
            isEdit = false;
        } else {
            console.log('el precio es', totalPrice);

            carrito[existingProductIndex].price += totalPrice*productQuantity;
            carrito[existingProductIndex].quantity += productQuantity;
            carrito[existingProductIndex].notes = notes;
            carrito[existingProductIndex].total = totalPrice;
            carrito[existingProductIndex].add = selectedAdditions;
        }
    } else {
        console.log('entro al else', productId);
        console.log('el precio es', totalPrice);

        carrito.push({
            id: productId,
            name: productName,
            price: totalPrice*productQuantity,
            quantity: productQuantity,
            notes: notes,
            total: totalPrice,
            add: selectedAdditions,
            position: currentPosition++
        });
    }

    console.log('Producto añadido al carrito:', carrito);
    quantity=0;
    updatePrice();
    updateCart();
    closeModal();
}


function carritoPrepared() {
    console.log('esperanza', carrito);
    for (let index = 0; index < carrito.length; index++) {
        const item = carrito[index];
        if (item.add && item.add.length > 0) {
            console.log('Prueba: Elemento con agregados en la posición', index);
            item.add.forEach(addition => {
                console.log("iteracion")
                // Buscar el agregado en el arreglo agregadosProducts
                const agregado = agregadosProducts.find(product => product.nombre === addition);
                if (agregado) {
                    carrito.splice(index + 1, 0, {
                        id: parseInt(agregado.idProducto),
                        name: agregado.nombre,
                        price: parseFloat(agregado.precio) * item.quantity,
                        quantity: item.quantity,
                        notes: "",
                        total: parseFloat(agregado.precio) * item.quantity,
                        add: [],
                        position: currentPosition++ // Asignar una nueva posición al agregado
                    });
                    index++; // Incrementar el índice para mantener la posición correcta
                } else {
                    console.log(`Agregado no encontrado: ${addition}`);
                }
            });
        }
    }
    console.log('esperanza2', carrito)
}


function updatePrice() {
    const totalCarrito = carrito.reduce((total, producto) => total + producto.price, 0);

    const priceElement = document.querySelector('.price');
    priceElement.innerText = `S/. ${totalCarrito.toFixed(2)}`;
}

const reiniciarButton = document.querySelector('.reiniciar');
reiniciarButton.addEventListener('click', () => {
    _showModal('modal-reiniciar');
    
});

function reiniciarPrecio() {
    carrito = [];
    
    // Actualizar la visualización del precio en la interfaz
    updatePrice();
    updateCart();
}

function mostrarCarrito() {
    var cartSidebar = document.getElementById("cart-sidebar");
    cartSidebar.classList.add("show"); // Añadimos la clase 'show' para activar la animación
}


function closeSidebar() {
    var cartSidebar = document.getElementById("cart-sidebar");
    cartSidebar.classList.remove("show"); // Removemos la clase 'show' para desactivar la animación
}

function toggleCarrito() {
    if (carritoAbierto) {
        closeSidebar();
    } else {
        mostrarCarrito();
    }
    // Cambiar el estado del carrito
    carritoAbierto = !carritoAbierto;
}
let carritoAbierto = false;


function updateCart() {
    var cartContainer = document.getElementById("cart-items");
    cartContainer.innerHTML = ""; // limpiar contenido anterior

    carrito.forEach((item, index) => {
        var cartItemDiv = document.createElement("div");
        cartItemDiv.classList.add("cart-item");
        
        // fila 1: cantidad nombre y precio
        var row1Div = document.createElement("div");
        row1Div.classList.add("row1div");
        row1Div.style.display = "flex"; 
        row1Div.style.justifyContent = "space-between"; 
        row1Div.style.fontWeight = "bold"; // Cambia a camelCase y agrega comillas al valor
        row1Div.style.marginBottom = "5px"; // Cambia a camelCase y agrega comillas al valor
       
        var quantitySpan = document.createElement("span");
        quantitySpan.textContent = item.quantity + " ";
        quantitySpan.classList.add("cart-quantity", "cart-label");
        row1Div.appendChild(quantitySpan);

        var nameSpan = document.createElement("span");
        nameSpan.textContent = item.name;
        nameSpan.classList.add("cart-product-name", "cart-label"); 
        row1Div.appendChild(nameSpan);

        var priceSpan = document.createElement("span");
        priceSpan.textContent = "S/. " + item.price.toFixed(2);
        priceSpan.classList.add("cart-price", "cart-label"); 
        row1Div.appendChild(priceSpan);

        cartItemDiv.appendChild(row1Div);

        // fila 2: indicaciones
        if (item.notes) {
            var row2Div = document.createElement("div");
            row2Div.classList.add("row");
            var notesSpan = document.createElement("span");
            notesSpan.textContent = "Notas: " + item.notes;
            notesSpan.classList.add("cart-notes");
            row2Div.appendChild(notesSpan);
            cartItemDiv.appendChild(row2Div);
        }

        // fila 3: agregados (solo si hay agregados)
        if (item.add && item.add.length > 0) {
            var row3Div = document.createElement("div");
            row3Div.classList.add("row");
            var addSpan = document.createElement("span");
            addSpan.textContent = "Agregados: " + item.add.join(', ');
            addSpan.classList.add("cart-add");
            row3Div.appendChild(addSpan);
            cartItemDiv.appendChild(row3Div);
        }

        // fila 4: botones de editar y eliminar
        var row4Div = document.createElement("div");
        row4Div.classList.add("row", "button-row");

        var editButton = document.createElement("button");
        editButton.classList.add("cart-edit-button");
        var editIcon = document.createElement("i");
        editIcon.classList.add("fas", "fa-edit"); 
        editButton.appendChild(editIcon);
        row4Div.appendChild(editButton);

        var deleteButton = document.createElement("button");
        deleteButton.classList.add("cart-delete-button");
        var deleteIcon = document.createElement("i");
        deleteIcon.classList.add("fas", "fa-trash-alt");
        deleteButton.appendChild(deleteIcon);
        row4Div.appendChild(deleteButton);

        cartItemDiv.appendChild(row4Div);

        cartContainer.appendChild(cartItemDiv);


        deleteButton.addEventListener('click', () => {
            _showModal('modal-eliminar-elemento');
        
            const modalAceptar = document.getElementById('modal-eliminar-elemento').querySelector('.send-btn');
            const modalCancelar = document.getElementById('modal-eliminar-elemento').querySelector('.back-btn');
        
            modalAceptar.addEventListener('click', () => {
                carrito.splice(index, 1);
                updateCart();
                _closeModal('modal-eliminar-elemento');
            });
        
            modalCancelar.addEventListener('click', () => {
                _closeModal('modal-eliminar-elemento');
                // Opcional: Puedes dejar este bloque vacío si no deseas realizar ninguna acción al cancelar
            });
        });
        
        //editar
        editButton.addEventListener('click', () => {
            isEdit=true;
            console.log("VOLVIENDO TRUE", isEdit)
            editCart(item);
        });
        
    });

    const totalCarrito = carrito.reduce((total, producto) => total + producto.price, 0);

    const totalTextElement = document.getElementById("total-text");
    totalTextElement.innerText = `Total: S/. ${totalCarrito.toFixed(2)}`;

    updatePrice();
}

function editCart(item) {
    const allProducts = document.querySelectorAll('.producto');
    let productoDeseado;
    
    allProducts.forEach((producto) => {
        const nombreProducto = producto.querySelector('.producto-nombre').innerText;

        if (nombreProducto === item.name) {
            productoDeseado = producto;
        }
    });
    
    if (productoDeseado) {
        const addToCartButton = document.getElementById('addToCartButton');
        addToCartButton.textContent = "Actualizar en el carrito";
        openModalWith(productoDeseado, item.price, item.quantity, item.notes, item.add);
    } else {
        console.log('No se encontró ningún producto con el nombre deseado.');
    }
}


