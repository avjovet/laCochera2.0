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
        console.log('indexx', existingProductIndex);
        carrito[existingProductIndex].price = productPrice;
        if(isEdit==true){
            console.log(isEdit)
            carrito[existingProductIndex].quantity = productQuantity; 

            isEdit=false;
        }else{
            console.log("isedit",isEdit)
            console.log('indexx else', existingProductIndex);
            carrito[existingProductIndex].quantity = productQuantity; 

        }
        carrito[existingProductIndex].notes = notes; // Actualizar las notas
        carrito[existingProductIndex].total =  productPrice; // Actualizar el total
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
    
    allProducts.forEach((producto) => {
        const nombreProducto = producto.querySelector('.producto-nombre').innerText;

        if (nombreProducto === item.name) {
            productoDeseado = producto;
        }
    });
    
    if (productoDeseado) {
        openModalWith(productoDeseado, item.price, item.quantity, item.notes);
    } else {
        console.log('No se encontró ningún producto con el nombre deseado.');
    }
}


