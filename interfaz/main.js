const dropdownIcon = document.querySelector("#menu__icon");
const dropdown = document.querySelector(".dropdown");
const productsCartId = {};
const productQuantities = {}; // Se utilizara para llevar un conteo del stock de cada producto0
dropdownIcon.addEventListener("click", () => {
    dropdown.classList.toggle("toggle--dropdown");
});

// Abrir y cerrar el carrito
function toggleCarrito() {
    document.querySelector(".cart").classList.toggle("active");
    document.querySelector(".cart").classList.toggle("inactive");
}

function toggleLoggin() {
    document.querySelector(".loggin").classList.toggle("active");
    document.querySelector(".loggin").classList.toggle("inactive");
}

//Para manejar las denuncias hechas a los productos
function denunciaProducto(idDenuncia) {
    fetch('../API/denunciaProducto.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            idDenuncia: idDenuncia 
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la solicitud: ' + response.status);
        }
        return response.json(); 
    })
    .then(data => {
        alert('Respuesta: ' + JSON.stringify(data)); 
    })
    .catch(error => {
        alert('Error: ' + error.message); 
    });
}



// RENDER SECTION

let listProducts = []; //Tienda con los items del JSON

fetch('../API/index.php') // Primer render con todos los items
.then(res => res.json())
.then(json => {
    listProducts = json;
    for (let i = 0; i < json.length; i++) {
        renderAll(json[i].titulo, json[i].imagen, json[i].precio_base, json[i].id_producto, json[i].habilitacion_producto, json[i].stock);
    }
}).catch((error) => console.log(error.message));

function renderAll(titulo, imagen, precio_base, id_producto, habilitacion_producto, stock) { //Funcion de renderizado de items
    if (habilitacion_producto == "Deshabilitado") {
        // Si el producto no esta habilitado no se renderiza ni se hace nada 
        return;
    }

    const renderZone = document.querySelector(".renderZone");

    const productWrap = document.createElement("div");

    const photoContainer = document.createElement("div");
    photoContainer.classList.add("photoContainer");

    const img = document.createElement("img"); 
    img.classList.add("imageClick");
    img.src = `${imagen}`;
    img.alt = `${titulo}`;
    img.id = `${id_producto}`; 

    const productName = document.createElement("span");
    productName.classList.add("titulo");

    if(titulo.length > 11) {
        productName.textContent = `${titulo.slice(0, 11)}...`;
    } else {
        productName.textContent = titulo;
    }

    const productPrice = document.createElement("span");
    productPrice.classList.add("price");
    productPrice.textContent = "$" + `${precio_base}`;

    const addCart = document.createElement("button");
    addCart.classList.add("addCart");
    addCart.textContent = "Añadir al Carrito";
    addCart.id = `${id_producto}`; 
    if (stock === 0) {
        addCart.disabled = true;
        addCart.textContent = "No hay STOCK";
    } else {
        addCart.disabled = false;
    }
    productWrap.classList.add("productWrap");
    productWrap.append(photoContainer);
    photoContainer.append(img);
    productWrap.append(productName, productPrice, addCart);
    renderZone.append(productWrap);
}

// Categorias: 
//chequea que clases tiene el elemento que esta capturando 
function capture(event) { 
    if (event.target.classList.contains('category')) { //Si el elemento clickeado es una categoria 
        event.preventDefault();
        const renderZone = document.querySelector(".renderZone");       
        renderZone.innerHTML = ``; //Limpia los elementos para renderizarlos despues

        const categoryEv = event.target.getAttribute('data-category'); //Capturando la informacion
        console.log(categoryEv);
        let categoryName = document.querySelector(".categoryName");
        categoryName.innerText = categoryEv.toUpperCase();

        for (let i = 0; i < listProducts.length; i++) {
            if (categoryEv == "CATALOG") {
                renderAll(listProducts[i].titulo, listProducts[i].imagen, listProducts[i].precio_base, listProducts[i].id_producto, listProducts[i].habilitacion_producto, listProducts[i].stock);
            } else if (listProducts[i].categoria == categoryEv) {
                renderAll(listProducts[i].titulo, listProducts[i].imagen, listProducts[i].precio_base, listProducts[i].id_producto, listProducts[i].habilitacion_producto, listProducts[i].stock);
            }
        }
    }

    if (event.target.classList.contains('addCart')) { // Si el elemento clickeado es el botón de añadir al carrito o addtocart de la pagina
        const productId = event.target.id; // Capturar el id del producto
        console.log(`Product ID: ${productId}`);
        const product = listProducts.find(item => item.id_producto == productId);
        renderCartItem(product.titulo, product.precio_base, product.id_producto,);
        updateTotalPrice();
    }

    if (event.target.classList.contains('buyItem')) { // Si el elemento clickeado es el botón de añadir al carrito o buyItem
        const productId = event.target.id; // Capturar el id del producto
        console.log(`Product ID: ${productId}`);
        const product = listProducts.find(item => item.id_producto == productId);
        renderCartItem(product.titulo, product.precio_base, product.id_producto);
        updateTotalPrice();
    }

    if (event.target.classList.contains('imageClick')) { // Si el elemento clickeado es la imagen de un artículo
        const productId = event.target.id; // Capturar el id del producto
        console.log(`Product ID: ${productId}`);
        const product = listProducts.find(item => item.id_producto == productId);
        renderArticleItem(product.titulo, product.precio_base, product.imagen, product.id_producto, product.descripcion, product.stock, product.id_empresa);
        document.querySelector(".articlePage").classList.toggle("active");
        document.querySelector(".articlePage").classList.toggle("inactive");
    }

    if (event.target.classList.contains('exitArticle')) { // Si el elemento clickeado es el botón de salir de la página del artículo
        document.querySelector(".articlePage").classList.toggle("active");
        document.querySelector(".articlePage").classList.toggle("inactive");
    }
}

// Buscador
document.querySelector('.search').addEventListener('submit', (event) => {
    event.preventDefault();
    const search = document.querySelector(".searchBar").value.toLowerCase(); //convierte a minuscula para la busqueda por nombre 
    const searchCATALOG = document.querySelector(".searchBar").value; // Para el texto de CATALOG 
    searchProducts(search, searchCATALOG);
});

function searchProducts(search, searchCATALOG) {
    const renderZone = document.querySelector('.renderZone');
    let categoryName = document.querySelector(".categoryName");
    renderZone.innerHTML = ''; // Limpia los productos que estaban antes 
    
    // Filtra productos por busqueda
    listProducts.forEach(product => {
        if (product.titulo.toLowerCase().includes(search) || search === '') {
            renderAll(product.titulo, product.imagen, product.precio_base, product.id_producto, product.habilitacion_producto, product.stock);
        }
    });
    
    // Actualiza el nombre de la categoria con la busqueda
    if (search === '') {
        categoryName.innerText = "CATALOGO"; // Cuando NO hay texto se pone CATALOGO
    } else {
        categoryName.innerText = searchCATALOG; // Cuando SI hay texto se pone el texto que se puso en la barra de busqueda 
    }
}


//resetea el catalogo al presionar el logo de la página
const logoPagina = document.querySelector("#logo_pagina");
logoPagina.addEventListener("click", (event) => {
    event.preventDefault(); 
    const renderZone = document.querySelector(".renderZone");
    renderZone.innerHTML = ``; 
    let categoryName = document.querySelector(".categoryName");
    categoryName.innerText = "CATALOGO";
    for (let i = 0; i < listProducts.length; i++) {
        renderAll(listProducts[i].titulo, listProducts[i].imagen, listProducts[i].precio_base, listProducts[i].id_producto, listProducts[i].habilitacion_producto, listProducts[i].stock);
    }
});

//carrito
document.addEventListener('click', capture);
//muestra los atributos para ponerlo en el carrito y los renderisa
function renderCartItem(titulo, precio_base, id_producto) {
    const cartItems = document.querySelector('.cartItems');

    // Incrementa la cantidad en el carrito o inicializa a 1 si es la primera vez
    productQuantities[id_producto] = (productQuantities[id_producto] || 0) + 1;
    const product = listProducts.find(item => item.id_producto == id_producto);
    if (productQuantities[id_producto] >= product.stock) {
        const buyItemButton = document.querySelector(`.buyItem[id="${id_producto}"]`);
        if (buyItemButton) {
            buyItemButton.disabled = true;
            buyItemButton.innerText = "No hay STOCK";
        }
        document.querySelector(`.addCart[id="${id_producto}"]`).disabled = true;
        document.querySelector(`.addCart[id="${id_producto}"]`).innerText = "No hay STOCK";
    }

    const productCart = document.createElement("div");
    productCart.classList.add("product__cart");
    productCart.id = id_producto;

    const cartName = document.createElement("h2");
    cartName.classList.add("cart__name");
    cartName.textContent = titulo;

    const cartPrice = document.createElement("p");
    cartPrice.classList.add("cart__price");
    cartPrice.textContent = `$${precio_base}`;

    const deleteButton = document.createElement("button");
    deleteButton.classList.add('btnCarrito');
    deleteButton.innerHTML = '<span class="material-symbols-outlined delCart">delete</span>';
    deleteButton.addEventListener('click', () => {
        removeCartItem(id_producto, productCart); 
        productCart.remove();
        updateTotalPrice();
    });

    productCart.append(cartName, cartPrice, deleteButton);
    cartItems.append(productCart);
}

function removeCartItem(id_producto, productCart) {
    const cartItems = document.querySelector('.cartItems');
    // Reduce la cantidad en el carrito
    productQuantities[id_producto]--;

    // Rehabilita los botones si la cantidad en el carrito es menor que el stock
    const product = listProducts.find(item => item.id_producto == id_producto);
    if (productQuantities[id_producto] < product.stock) {
        document.querySelector('.buyItem').disabled = false;
        document.querySelector('.buyItem').innerText = "Añadir al carrito";
        document.querySelector(`.addCart[id="${id_producto}"]`).disabled = false;
        document.querySelector(`.addCart[id="${id_producto}"]`).innerText = "Añadir al carrito";
    }
}


//actualiza el precio total
function updateTotalPrice() {
    const cartItems = document.querySelectorAll('.product__cart');
    let totalPrice = 0;
//por cada objeto del carrito combierte el texto de precio del producto en un float remobiendo caracteres no deseados y los suma al total
    cartItems.forEach(item => {
        const precio_base = parseFloat(item.querySelector('.cart__price').textContent.replace('$', ''));
        totalPrice += precio_base;
    });

    document.querySelector('.checkout span').textContent = `TOTAL: $${totalPrice.toFixed(2)}`;
    document.getElementById('cantidad').value = `${totalPrice.toFixed(2)}`;
}

// Función para renderizar el artículo en la página de artículo
function renderArticleItem(titulo, precio_base, image, id_producto, descripcion, stock, id_empresa) {
    document.querySelector('.articlePageTitle').textContent = `${titulo} - $${precio_base}`;
    document.querySelector('.imgArticlePage').src = image;
    document.querySelector('.imgArticlePage').alt = titulo;
    document.querySelector('.buyItem').id = id_producto;
    const descripcionConSaltos = descripcion.replace(/\n/g, '<br>'); 
    document.querySelector('.descriptionArticleText').innerHTML = descripcionConSaltos;
    document.querySelector('.empresaTexto').innerText = 'Publicado por: '+id_empresa;
    document.querySelector('.stockTexto').innerText = 'STOCK: '+stock;
    document.querySelector('.denunciaProducto').id = id_producto;
    if(stock == 0 || productQuantities[id_producto] >= stock) {
        document.querySelector('.buyItem').disabled = true;
        document.querySelector('.buyItem').innerText = "No hay STOCK";
    }else{
        document.querySelector('.buyItem').disabled = false;
        document.querySelector('.buyItem').innerText = "Añadir al Carro";
    }
}


//paypal
document.querySelector('.paybtn').addEventListener('click', function() {
    const cartItems = document.querySelectorAll('.product__cart');
    let itemsArray = [];
    let totalAmount = 0; // Variable para almacenar el total a pagar

    cartItems.forEach(item => {
        const id_producto = item.id; // Usamos el id del elemento
        const product = listProducts.find(product => product.id_producto == id_producto); 
        const precio_base = parseFloat(product.precio_base); // Obtener el precio del producto
        totalAmount += precio_base; // Sumar el precio al total
        //alert(totalAmount);
        // Empujar cada artículo al array
        itemsArray.push({
            titulo: product.titulo,
            precio_base: precio_base,
            id_producto: id_producto
        });
    });
    totalAmount = parseFloat(totalAmount.toFixed(2));
    fetch('../API/articulosCarrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            items: itemsArray // Aquí se envían los artículos
        })
    })
    .then(response => response.json())
    .then(data => {
        // Enviar la solicitud a la API para crear el pago
    fetch('../API/metodosDePago/paypal_payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            amount: totalAmount, // Monto a pagar
            currency: 'USD', // Moneda
            description: 'Compra de prueba'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.approvalUrl) {
            // Redirigir al usuario a PayPal para completar el pago
            window.location.href = data.approvalUrl;
        } else {
            console.error('Error al generar el pago:', data.error);
        }
    })
    .catch(error => alert('Error en la solicitud: ' + error));
        
    })
    .catch(error => {
        alert('Error en la solicitud: ' + error + '. No se procedera al pago.');
        return;
    });

    
});