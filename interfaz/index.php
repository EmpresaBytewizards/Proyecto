<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeSHop store -best deals-</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>
        <div class="header__top">
            <div class="logo__container">
                <img id="logo_pagina" src="tienda/Logopagina tr borde.png" data-category="CATALOG">
            </div>
            <nav>
                
                <div class="menu">
                    <span id="menu__icon" class="material-symbols-outlined">menu</span>
                    
                    <ul class="dropdown">
                        <li><a href="#" class="category" data-category="tecnologia">Tecnologia</a></li>
                        <li><a href="#" class="category" data-category="joyeria">Joyeria</a></li>
                        <li><a href="#" class="category" data-category="ropa">Ropa</a></li>
                        <li><a href="#" class="category" data-category="animales">Animales</a></li>
                        <li><a href="#" class="category" data-category="consumibles">Consumibles</a></li>
                        <li><a href="#" class="category" data-category="juegos">Juegos</a></li>
                    </ul>
                </div>
                <form action="" class="search">
                    <input class="searchBar" type="search" placeholder="Buscar...">
                    <button class="material-symbols-outlined">
                        search
                    </button>
                </form>

                <div class="icons">
                    <button alt="cuenta" class="btnLoggin" onclick="toggleLoggin()"> <span class="material-symbols-outlined">passkey</span> </button>
                    <button alt="carrito" class="btnCarrito" onclick="toggleCarrito()"> <span class="material-symbols-outlined">shopping_cart</span> </button>
                </div>
            </nav>
        </div>
        <div class="blackbar">FREE SHIPPING AND RETURNS </div>
    </header>
    <main>
        <!--<section class="concarrusel">-->
           <br>
            <div class="carrusel">
                <div id="publi" class="publi"></div>
            </div>
        
    
        <script src="carrusel.js"></script>

        <div class="flexCenter">
            <h1 class="categoryName">CATALOGO</h1>
        </div>
        <div class="renderZone">
        </div>
        <br>

        
    </main>
    <section class="cart inactive">
        <div class="cartContainer">
            <div class="cart__title">
                <button class="btnCarrito" onclick="toggleCarrito()"> <span class="material-symbols-outlined closeCarrito"> close </span> </button>
                
                <h1>CARRITO</h1>
            </div>
            <div class="cartItems"> <!-- Lugar de renderizado del carrito -->

            </div> 
            <div class="checkout">
                <span class="total">TOTAL: $0.00</span>
                <button class="paybtn">Pasar al Pago</button>
            </div>
        </div>
    </section>

    <section class="loggin inactive">
        
        <div class="login-container">
            <div class="loggin__title">
                <button alt="carrito" class="btnLoggin" onclick="toggleLoggin()"> <span class="material-symbols-outlined closeLogin">close</span> </button>      
                <h1 id="logintitulo">Inicio de Sesion</h1>
            </div>
            <form>
                <label for="email">Email/Nombre:</label>
                <input type="text" id="email" name="email" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" class="continueLoggin">Iniciar Sesion</button>
                <p><a href="register.html">¿Aun no tienes una cuenta? ¡Registrate ahora!</a></p>
            </form>
        </div>
    </section>
    
    <section class="articlePage inactive">
        
        <div class="articlePage-container">
            <div class="articlePage__title">
                <button alt="articlePageExit" class="exitArticle"> <span class="material-symbols-outlined exitArticle">close</span> </button>    
                <br>  
                <img src="" class="imgArticlePage">
                <h1 class="articlePageTitle"> </h1>
            </div>
            <button type="submit" class="buyItem">Añadir al Carro</button>
            <br>
            <div class="stockYempresa">
                <h3 id="stockArticleText" class="stockTexto"> STOCK: </h3>
                <h3 id="empresaText" class="empresaTexto"> Publicador: </h3>
            </div>
            <br>
            <div class="descriptionArticle">
                <h3 id="descripcionTexto"> Descripcion: </h3>
                <br>
                <p class="descriptionArticleText"> </p>
            </div>
            <div class="commentSection">
                <h2> ¡Comentar! </h2>
                <form class="commentForm">
                    <div class="formGroup">
                        <label for="nick">Nombre: Anonimo </label>
                        <label for="comment">Comentario:</label>
                        <textarea id="comment" class="inputComment" rows="8" required></textarea>
                    </div>
                    <button class="sendbtn">Enviar</button>
                </form>
            </div>
            
        </div>
    </section>


    <footer>
        <div>
            <div class="">
                <ul>
                    <li>Contact:</li>
                    <li>Send us an email: bytewizards@gmail.com</li>
                    <li>Phone: xxx-xx-xx</li>
                </ul>
            </div>
            <div class="">
                <ul>
                    <li>Client:</li>
                    <li>DGETP-UTU</li>
                    <li>Phone: 2208 9891</li>
                </ul>
            </div>
            <div class="">
                <ul>
                    <li>Development Team:</li>
                    <li>byteWizards Corporation</li>
                </ul>
            </div>
        </div>
    </footer>
</body>
<script src="main.js"></script>
<script src="commentary.js"></script>
<script src="jquery-3.7.1.min.js"></script>
</html>

<!-- <div class="">
    <a href="#"><span class="material-symbols-outlined">passkey</span></a>
    <a href="#"><span class="material-symbols-outlined">shopping_cart</span></a>
</div> -->


<!-- <span class="material-symbols-outlined">menu</span> -->