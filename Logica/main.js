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
    // document.querySelector(".renderZone").classList.toggle("pointer__events");
    // document.querySelector("#principalHeader").classList.toggle("pointer__events");
}

function toggleLoggin() {
    document.querySelector(".loggin").classList.toggle("active");
    document.querySelector(".loggin").classList.toggle("inactive");
    // document.querySelector(".renderZone").classList.toggle("pointer__events");
    // document.querySelector("#principalHeader").classList.toggle("pointer__events");
}


// RENDER SECTION

let listProducts = []; //Tienda con los items del JSON

fetch('https://fakestoreapi.com/products') // Primer render con todos los items
.then(res => res.json())
.then(json => {
    listProducts = json;
    for (let i = 0; i < json.length; i++) {
        renderAll(json[i].title, json[i].image, json[i].price, json[i].id);
    }
}).catch((error) => console.log(error.message));



function renderAll(title, image, price, id) { //Funcion de renderizado de items

    const renderZone = document.querySelector(".renderZone");

    const productWrap = document.createElement("div");

    const photoContainer = document.createElement("div");
    photoContainer.classList.add("photoContainer");
    const img = document.createElement("img");
    img.classList.add("imageClick");
    img.src = `${image}`;
    img.alt = `${title}`;
    img.id = `${id}`; 
      
    const productName = document.createElement("span");
    productName.classList.add("title");


    if(title.length > 11){
        productName.textContent = `${title.slice(0, 11)}...`;
    } else{ productName.textContent = title}

    const productPrice = document.createElement("span");
    productPrice.classList.add("price");
    productPrice.textContent="$"+`${price}`;
    const addCart = document.createElement("button");
    addCart.classList.add("addCart");
    addCart.textContent = "Add To Cart";
    addCart.id = `${id}`; 

    productWrap.classList.add("productWrap");
    productWrap.append(photoContainer);
    photoContainer.append(img);
    productWrap.append(productName, productPrice, addCart);
    renderZone.append(productWrap);

    
}

//Categorias: 
function capture(event){ //Agarra el nombre de la categoria al clickearla 

    if (event.target.classList.contains('category')) { //Si el elemento clickeado es una categoria capturamos la informacion

        event.preventDefault();
        const renderZone = document.querySelector(".renderZone");       
        renderZone.innerHTML = ``; //Limpia los elementos para renderizarlos despues


        const categoryEv = event.target.getAttribute('data-category'); //Capturando la informacion
        console.log(categoryEv);
        let categoryName = document.querySelector(".categoryName");
        categoryName.innerText = categoryEv.toUpperCase();


        for (let i = 0; i < listProducts.length; i++) {
            if(categoryEv == "CATALOG"){
                renderAll(listProducts[i].title, listProducts[i].image, listProducts[i].price, listProducts[i].id);
            }
            else if(listProducts[i].category == categoryEv){
                renderAll(listProducts[i].title, listProducts[i].image, listProducts[i].price, listProducts[i].id);
            }
        }
    }
    if (event.target.classList.contains('addCart')) { // Si el elemento clickeado es el botón de añadir al carrito o addtocart de la pagina
        const productId = event.target.id; // Capturar el id del producto
        console.log(`Product ID: ${productId}`);
        const product = listProducts.find(item => item.id == productId);
        renderCartItem(product.title, product.price, product.id);
        updateTotalPrice();
    }
    if (event.target.classList.contains('buyItem')) { // Si el elemento clickeado es el botón de añadir al carrito o addtocart de la pagina
        const productId = event.target.id; // Capturar el id del producto
        console.log(`Product ID: ${productId}`);
        const product = listProducts.find(item => item.id == productId);
        renderCartItem(product.title, product.price, product.id);
        updateTotalPrice();
    }
    if (event.target.classList.contains('imageClick')) { // Si el elemento clickeado es la imagen de un articulo
        const productId = event.target.id; // Capturar el id del producto
        console.log(`Product ID: ${productId}`);
        const product = listProducts.find(item => item.id == productId);
        renderArticleItem(product.title, product.price, product.image, product.id);
        document.querySelector(".articlePage").classList.toggle("active");
        document.querySelector(".articlePage").classList.toggle("inactive");
    }
    if (event.target.classList.contains('exitArticle')) { // Si el elemento clickeado es el boton de salir de la pagina del articulo
        document.querySelector(".articlePage").classList.toggle("active");
        document.querySelector(".articlePage").classList.toggle("inactive");
    }
}

document.addEventListener('click', capture);

function renderCartItem(title, price, id) {
    const cartItems = document.querySelector('.cartItems');

    const productCart = document.createElement("div");
    productCart.classList.add("product__cart");

    const cartName = document.createElement("h2");
    cartName.classList.add("cart__name");
    cartName.textContent = title;

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
    let totalPrice = 0;  // Inicializar totalPrice como un número

    cartItems.forEach(item => {
        // Obtener el precio del elemento como número (usar parseFloat si es necesario)
        const price = parseFloat(item.querySelector('.cart__price').textContent.replace('$', ''));
        totalPrice += price;  // Sumar al totalPrice
    });

    // Actualizar el texto del total en el DOM
    document.querySelector('.checkout span').textContent = `TOTAL: $${totalPrice.toFixed(2)}`;
}

// Función para renderizar el artículo en la página de artículo
function renderArticleItem(title, price, image, id) {
    document.querySelector('.articlePageTitle').textContent = `${title} - $${price}`;
    document.querySelector('.imgArticlePage').src = image;
    document.querySelector('.imgArticlePage').alt = title;
    document.querySelector('.buyItem').id = id; 
}