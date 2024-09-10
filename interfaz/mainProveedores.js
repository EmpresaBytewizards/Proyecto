const dropdownIcon = document.querySelector("#menu__icon");
const dropdown = document.querySelector(".dropdown");
dropdownIcon.addEventListener("click", () => {
    dropdown.classList.toggle("toggle--dropdown");
});

// Abrir y cerrar el carrito
function toggleAñadirProducto() {
    document.querySelector(".productAdd").classList.toggle("active");
    document.querySelector(".productAdd").classList.toggle("inactive");
}

function toggleLoggin() {
    document.querySelector(".loggin").classList.toggle("active");
    document.querySelector(".loggin").classList.toggle("inactive");
}


function toggleEditarProducto() {
    document.querySelector(".productEdit").classList.toggle("active");
    document.querySelector(".productEdit").classList.toggle("inactive");

}

// RENDER SECTION

let listProducts = []; //Tienda con los items del JSON

fetch('http://localhost/bytewizzards/API/conectarAPI.php') // Primer render con todos los items
.then(res => res.json())
.then(json => {
    listProducts = json;
    for (let i = 0; i < json.length; i++) {
        renderAll(json[i].titulo, json[i].imagen, json[i].precio_base, json[i].id_producto, json[i].habilitacion_producto, json[i].stock, json[i].nombre_empresa);
    }
}).catch((error) => console.log(error.message));

function renderAll(titulo, imagen, precio_base, id_producto, habilitacion_producto, stock, nombre_empresa) { //Funcion de renderizado de items
    if (nombre_empresa != "ByteWizzards") {
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

    const editArticle = document.createElement("button");
    editArticle.classList.add("editArticle");
    editArticle.onclick = toggleEditarProducto; 
    editArticle.textContent = "Editar";
    editArticle.id = `${id_producto}`; 
    productWrap.classList.add("productWrap");
    productWrap.append(photoContainer);
    photoContainer.append(img);
    productWrap.append(productName, productPrice, editArticle);
    renderZone.append(productWrap);
}

// Categorias: 
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
                renderAll(listProducts[i].titulo, listProducts[i].imagen, listProducts[i].precio_base, listProducts[i].id_producto, listProducts[i].habilitacion_producto, listProducts[i].stock, listProducts[i].nombre_empresa);
            } else if (listProducts[i].categoria == categoryEv) {
                renderAll(listProducts[i].titulo, listProducts[i].imagen, listProducts[i].precio_base, listProducts[i].id_producto, listProducts[i].habilitacion_producto, listProducts[i].stock, listProducts[i].nombre_empresa);
            }
        }
    }

    if (event.target.classList.contains('editArticle')) { // Si el elemento clickeado es el botón de editar articulo
        const productId = event.target.id; // Capturar el id del producto
        console.log(`Product ID: ${productId}`);
        const product = listProducts.find(item => item.id_producto == productId);
    }

    if (event.target.classList.contains('editarItem')) { // Si el elemento clickeado es el boton de editar 
        const productId = event.target.id; // Capturar el id del producto
        console.log(`Product ID: ${productId}`);
        const product = listProducts.find(item => item.id_producto == productId);
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

    if (event.target.classList.contains('editArticle')) {
        const productId = event.target.id;
        editarProducto(productId);
    }
    
    if (event.target.classList.contains('editarItem')) {
        const productId = event.target.id;
        editarProducto(productId);
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
            renderAll(product.titulo, product.imagen, product.precio_base, product.id_producto, product.habilitacion_producto, product.stock, product.nombre_empresa);
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
        renderAll(listProducts[i].titulo, listProducts[i].imagen, listProducts[i].precio_base, listProducts[i].id_producto, listProducts[i].habilitacion_producto, listProducts[i].stock, listProducts[i].nombre_empresa);
    }
});

document.addEventListener('click', capture);

// Función para renderizar el artículo en la página de artículo
function renderArticleItem(titulo, precio_base, image, id_producto, descripcion, stock, nombre_empresa) {
    document.querySelector('.articlePageTitle').textContent = `${titulo} - $${precio_base}`;
    document.querySelector('.imgArticlePage').src = image;
    document.querySelector('.imgArticlePage').alt = titulo;
    document.querySelector('.editarItem').id = id_producto;
    const descripcionConSaltos = descripcion.replace(/\n/g, '<br>'); 
    document.querySelector('.descriptionArticleText').innerHTML = descripcionConSaltos;
    document.querySelector('.empresaTexto').innerText = 'Publicado por: '+nombre_empresa;
    document.querySelector('.stockTexto').innerText = 'STOCK: '+stock;
}


document.getElementById('productForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Recolectar los datos del formulario
    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    // Enviar los datos al servidor
    fetch('http://localhost/bytewizzards/API/crearArticulos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);
        alert("¡Articulo creado exitosamente!");
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});


















function editarProducto(productId) {
    fetch(`http://localhost/bytewizzards/API/conectarAPI.php?id=${productId}`)
      .then(response => response.json())
      .then(producto => {
        console.log(producto); // Añade esto para ver la respuesta del servidor
        document.getElementById('habilitacionProducto').value = producto.habilitacion_producto || '';
        document.getElementById('editProductId').value = producto.id_producto || '';
        document.getElementById('editNombreProducto').value = producto.titulo || '';
        document.getElementById('editStockProducto').value = producto.stock || '';
        document.getElementById('editProductImage').value = producto.imagen || '';
        document.getElementById('editPrecioProducto').value = producto.precio_base || '';
        document.getElementById('editCondicionProducto').value = producto.condicion || '';
        document.getElementById('editCategoriaProducto').value = producto.categoria || '';
        document.getElementById('editDescripcionProducto').value = producto.descripcion || '';
  
        document.getElementById('editProductSection').classList.remove('inactive');
      })
      .catch(error => console.error('Error al obtener el producto:', error));
  }
  

// Función para manejar la actualización del producto
document.getElementById('editProductForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Recolectar los datos del formulario de edición
    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => {
      data[key] = value;
    });

    // Enviar los datos al servidor para actualizar el producto
    fetch('http://localhost/bytewizzards/API/editarArticulos.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(responseData => {
      console.log(responseData.message);
      alert("¡Articulo editado exitosamente!")
      location.reload();
    })
    .catch(error => console.error('Error al actualizar el producto:', error));
});