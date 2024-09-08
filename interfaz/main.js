const dropdownIcon = document.querySelector("#menu__icon");
const dropdown = document.querySelector(".dropdown");
const productsCartId = {};
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

// RENDER SECTION

let listProducts = []; //Tienda con los items del JSON

fetch('http://localhost/bytewizzards/API/conectarAPI.php') // Primer render con todos los items
.then(res => res.json())
.then(json => {
    listProducts = json;
    for (let i = 0; i < json.length; i++) {
        renderAll(json[i].titulo, json[i].imagen, json[i].precio_base, json[i].id_producto, json[i].habilitacionProducto, json[i].stock);
    }
}).catch((error) => console.log(error.message));

function renderAll(titulo, imagen, precio_base, id, habilitacionProducto, stock) { //Funcion de renderizado de items
    if (habilitacionProducto == "Deshabilitado") {
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
    img.id = `${id}`; 

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
    addCart.id = `${id}`; 
    addCart.disabled = stock === 0; // Deshabilita si el stock es igual a 0
    if(addCart.disabled) {
        addCart.textContent = "No hay STOCK";
    }
    productWrap.classList.add("productWrap");
    productWrap.append(photoContainer);
    photoContainer.append(img);
    productWrap.append(productName, productPrice, addCart);
    renderZone.append(productWrap);
}

// Categorias: 
function capture(event) { //Agarra el nombre de la categoria al clickearla 
    if (event.target.classList.contains('category')) { //Si el elemento clickeado es una categoria capturamos la informacion
        event.preventDefault();
        const renderZone = document.querySelector(".renderZone");       
        renderZone.innerHTML = ``; //Limpia los elementos para renderizarlos despues

        const categoryEv = event.target.getAttribute('data-category'); //Capturando la informacion
        console.log(categoryEv);
        let categoryName = document.querySelector(".categoryName");
        categoryName.innerText = categoryEv.toUpperCase();

        for (let i = 0; i < listProducts.length; i++) {
            if (categoryEv == "CATALOG") {
                renderAll(listProducts[i].titulo, listProducts[i].imagen, listProducts[i].precio_base, listProducts[i].id_producto, listProducts[i].habilitacionProducto);
            } else if (listProducts[i].categoria == categoryEv) {
                renderAll(listProducts[i].titulo, listProducts[i].imagen, listProducts[i].precio_base, listProducts[i].id_producto, listProducts[i].habilitacionProducto);
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
        renderArticleItem(product.titulo, product.precio_base, product.imagen, product.id_producto, product.descripcion, product.stock, product.nombre_empresa);
        document.querySelector(".articlePage").classList.toggle("active");
        document.querySelector(".articlePage").classList.toggle("inactive");
    }

    if (event.target.classList.contains('exitArticle')) { // Si el elemento clickeado es el botón de salir de la página del artículo
        document.querySelector(".articlePage").classList.toggle("active");
        document.querySelector(".articlePage").classList.toggle("inactive");
    }
}

// Buscador
document.querySelector('.searchBar').addEventListener('input', (event) => {
    const search = event.target.value.toLowerCase(); // Para la busqueda por nombre 
    const searchCATALOG = event.target.value; // Para el texto de CATALOG 
    searchProducts(search, searchCATALOG);
});

function searchProducts(search, searchCATALOG) {
    const renderZone = document.querySelector('.renderZone');
    let categoryName = document.querySelector(".categoryName");
    renderZone.innerHTML = ''; // Limpia los productos que estaban antes 
    
    // Filtra productos por busqueda
    listProducts.forEach(product => {
        if (product.titulo.toLowerCase().includes(search) || search === '') {
            renderAll(product.titulo, product.imagen, product.precio_base, product.id_producto, product.habilitacionProducto);
        }
    });
    
    // Actualiza el nombre de la categoria con la busqueda
    if (search === '') {
        categoryName.innerText = "CATALOGO"; // Cuando NO hay texto se pone CATALOGO
    } else {
        categoryName.innerText = searchCATALOG; // Cuando SI hay texto se pone el texto que se puso en la barra de busqueda 
    }
}



const logoPagina = document.querySelector("#logo_pagina");

logoPagina.addEventListener("click", (event) => {
    event.preventDefault(); 

    const renderZone = document.querySelector(".renderZone");
    renderZone.innerHTML = ``; 

    let categoryName = document.querySelector(".categoryName");
    categoryName.innerText = "CATALOGO";

    for (let i = 0; i < listProducts.length; i++) {
        renderAll(listProducts[i].titulo, listProducts[i].imagen, listProducts[i].precio_base, listProducts[i].id_producto, listProducts[i].habilitacionProducto);
    }
});

document.addEventListener('click', capture);

function renderCartItem(titulo, price, id) {
    const cartItems = document.querySelector('.cartItems');

    const productCart = document.createElement("div");
    productCart.classList.add("product__cart");

    const cartName = document.createElement("h2");
    cartName.classList.add("cart__name");
    cartName.textContent = titulo;

    const cartPrice = document.createElement("p");
    cartPrice.classList.add("cart__price");
    cartPrice.textContent = `$${price}`;

    const deleteButton = document.createElement("button");
    deleteButton.classList.add('btnCarrito');
    deleteButton.innerHTML = '<span class="material-symbols-outlined">delete</span>';
    deleteButton.addEventListener('click', () => {
        productCart.remove();
        updateTotalPrice();
    });

    productCart.append(cartName, cartPrice, deleteButton);
    cartItems.append(productCart);
}

function updateTotalPrice() {
    const cartItems = document.querySelectorAll('.product__cart');
    let totalPrice = 0;

    cartItems.forEach(item => {
        const price = parseFloat(item.querySelector('.cart__price').textContent.replace('$', ''));
        totalPrice += price;
    });

    document.querySelector('.checkout span').textContent = `TOTAL: $${totalPrice.toFixed(2)}`;
}

// Función para renderizar el artículo en la página de artículo
function renderArticleItem(titulo, price, image, id, descripcion, stock, nombre_empresa) {
    document.querySelector('.articlePageTitle').textContent = `${titulo} - $${price}`;
    document.querySelector('.imgArticlePage').src = image;
    document.querySelector('.imgArticlePage').alt = titulo;
    document.querySelector('.buyItem').id = id;
    const descripcionConSaltos = descripcion.replace(/\n/g, '<br>'); 
    document.querySelector('.descriptionArticleText').innerText = descripcionConSaltos;
    document.querySelector('.empresaTexto').innerText = 'Publicado por: '+nombre_empresa;
    document.querySelector('.stockTexto').innerText = 'STOCK: '+stock;
    if(stock == 0) {
        document.querySelector('.buyItem').disabled = true;
        document.querySelector('.buyItem').innerText = "No hay STOCK";
    }else{
        document.querySelector('.buyItem').disabled = false;
        document.querySelector('.buyItem').innerText = "Añadir al Carro";
    }
}
