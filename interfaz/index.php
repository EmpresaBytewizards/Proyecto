<?php
session_start(); 
if (!empty($_SESSION['usuarios'])) {
    require("../API/ConexionDB.php");

    // Configuración de la base de datos
    $host = 'localhost';
    $dbname = 'weshop';
    $username = 'root';
    $password = ''; // Cambia la contraseña si es necesario

    $conexionDB = new ConexionDB($host, $dbname, $username, $password);
    $pdo = $conexionDB->getPDO();
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id_usu = ?");
    $stmt->execute([$_SESSION['usuarios'][0]['id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        $_SESSION['usuarios'][0] = [ 
            'id' => $usuario['id_usu'],
            'nombre' => $usuario['nombre_usu'],
            'correo' => $usuario['mail_usu'],
            'direccion' => $usuario['direccion_usu'],
            'numero' => $usuario['telefono_usu'],
            'habilitacion' => $usuario['habilitacion_usu']
        ];
    }
}
if (isset($_SESSION['usuarios'])) {
    if ($_SESSION['usuarios'][0]['habilitacion'] == "Deshabilitado"){
        header("Location: noIniciadoUsu.php");
    }
}
?>

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
                        <li><a href="#" class="category" data-category="juegos">Juegos</a></li>
                        <li><a href="#" class="category" data-category="otros">Otros</a></li>
                    </ul>
                </div>
                <form action="" class="search">
                    <input class="searchBar" type="search" placeholder="Buscar...">
                    <button type="submit" class="material-symbols-outlined">
                        search
                    </button>
                </form>

                <div class="icons">
                    <button alt="cuenta" class="btnLoggin" onclick="toggleLoggin()"> <span class="material-symbols-outlined">passkey</span> </button>
                    <button alt="carrito" class="btnCarrito" onclick="toggleCarrito()"> <span class="material-symbols-outlined">shopping_cart</span> </button>
                </div>
            </nav>
        </div>
        <div class="blackbar"> ENVÍO Y DEVOLUCIONES GRATIS </div>
    </header>
    <main>
        <!--<section class="concarrusel">-->
           <br>
            <div class="carrusel">
                <div id="publi" class="publi"></div>
            </div>
        
    
        <script src="carrusel.js"></script>
        <?php if (isset($_SESSION['usuarios'])) { ?> <p><a href="historial.php" style='color: #007BFF;'>¿Desea ver su historial de compras? ¡Presione aquí!</a></p> <?php } ?>

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
            
            <?php 
            if (!empty($_SESSION['usuarios'])) {
            
            ?>
            
            <div class="checkout">
                <span class="total">TOTAL: $0.00</span>
                <input type="hidden" id="cantidad" require> 
                <button class="paybtn">Pasar al Pago por PayPal</button>
                <span style="color: black"> El envio se hara a la direccion almacenada en su cuenta </span>
                <span style="color: black"> (Se aplicaran impuestos correspondientes despues de pasar al pago) </span>
            </div>
            
            <?php
            }else{
            ?>
            <div class="checkout">
                <span class="total">TOTAL: $0.00</span>
                <span style="color: black"> El envio se hara a la direccion almacenada en su cuenta </span>
                <span style="color: black"> (Se aplicaran impuestos correspondientes despues de pasar al pago) </span>
            </div>
            <?php
            }
            ?>
        </div>
        <?php
        if(empty($_SESSION['usuarios'])){
        ?>
            <div class="checkout">
                <h2>¡DEBES INICIAR SESION PARA PODER COMPRAR AQUÍ!</h2>
            </div>
        <?php
        }
        ?>
    </section>

    <section class="loggin inactive">
        
    <?php 


// Verificar si el usuario está logueado
if (!isset($_SESSION['usuarios']) || empty($_SESSION['usuarios'])) {
    // Si no está logueado, mostrar el formulario de inicio de sesión
    ?>
    <div class="login-container">
        <div class="loggin__title">
            <button alt="cerrar" class="btnLoggin" onclick="toggleLoggin()"> 
                <span class="material-symbols-outlined closeLogin">close</span> 
            </button>      
            <h1 id="logintitulo">Inicio de Sesion</h1>
        </div>
        <form action class="inicioSesion">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="continueLoggin">Iniciar Sesion</button>
            <p><a href="register.php">¿Aun no tienes una cuenta? ¡Registrate ahora!</a></p>
            <p><a href="loginProveedores.php">¿Desea ingresar como proveedor? ¡Presiona aquí!</a></p>
            <p><a href="loginStaff.php">¿Trabajas aquí? ¡Presiona aquí!</a></p>
        </form>
    </div>
    <?php
} else {
    ?>
    <!-- Se utilizan las clases de Login para utilizar el mismo diseño pero se utilizara otra funcion en el boton -->
    <div class="login-container">
        <div class="loggin__title">
            <button alt="cerrar" class="btnLoggin" onclick="toggleLoggin()"> 
                <span class="material-symbols-outlined closeLogin">close</span> 
            </button>      
            <h1 id="logintitulo">Perfil</h1>
        </div>
        <form action id="perfilUsu">
            <br>
            <h3 style="color: black;"> Su id de usuario es: <?php echo $_SESSION['usuarios'][0]['id']; ?></h3> 
            <label for="cambiarEmail" style="color: black;">Email: <?php echo $_SESSION['usuarios'][0]['correo']; ?></label>
            <input type="text" id="cambiarEmail" name="cambiarEmail" required placeholder="Cambiar correo..." value="<?php echo $_SESSION['usuarios'][0]['correo']; ?>">
            <label for="cambiarName">Nombre: <?php echo $_SESSION['usuarios'][0]['nombre']; ?></label>
            <input type="text" id="cambiarName" name="cambiarName" required placeholder="Cambiar nombre..." value="<?php echo $_SESSION['usuarios'][0]['nombre']; ?>">
            <label for="cambiarDirection">Direccion: <?php echo $_SESSION['usuarios'][0]['direccion']; ?></label>
            <input type="text" id="cambiarDirection" name="cambiarDirection" required placeholder="Cambiar direccion..." value="<?php echo $_SESSION['usuarios'][0]['direccion']; ?>">
            <label for="cambiarNumero">Número de Telefono: <?php echo $_SESSION['usuarios'][0]['numero']; ?></label>
            <input type="number" id="cambiarNumero" name="cambiarNumero" required placeholder="Cambiar telefono..." value="<?php echo $_SESSION['usuarios'][0]['numero']; ?>">
            
            <label for="cambiarPassword">Contraseña:</label>
            <ul class="required">
                <li id="caractMin" class="reject"> Minímo 5 caracteres. </li>
                <li id="mayMin" class="reject"> Minímo 1 letra mayuscula. </li>
                <li id="minMin" class="reject"> Minímo 1 letra minuscula. </li>
                <li id="minNum" class="reject"> Al menos 1 número. </li>
            </ul>
            <input type="password" id="cambiarPassword" name="cambiarPassword" required  placeholder="Cambiar contraseña...">
            <label for="password2">Repita su contraseña:</label>
            <input type="password" id="password2" name="password2" required placeholder="Ingrese la contraseña nuevamente...">
            <span style="color: black;"> Debes llenar todos los espacios para poder actualizar su perfil. </span>
            <button type="submit" class="continueLoggin">Actualizar informacion</button>
            <p><a href="../API/sessionDestroy.php">¿Quieres cerrar sesion? ¡Presione aquí!</a></p>
        </form>
    </div>
    <?php
}
?>

    </section>
    
    <section class="articlePage inactive">
        
        <div class="articlePage-container">
            <button class="denunciaProducto" style="border:none; background:none; float: right; font-size: 20px;" onclick="denunciaProducto(this.id)">❗</button>
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
                <?php
                if (empty($_SESSION['usuarios'])) {
                ?>
                <h2> DEBES INICIAR SESION PARA PODER COMENTAR </h2>
                <?php
                }else{
                ?>
                <form class="commentForm">
                    <div class="formGroup">
                        <label for="nick">Nombre: <?php echo $_SESSION['usuarios'][0]['nombre']; ?> </label>
                        <label for="comment">Comentario:</label>
                        <textarea id="comment" class="inputComment" rows="8" required></textarea>
                    </div>
                    <button class="sendbtn">Enviar</button>
                </form>
                <?php 
                }
                ?>
                <br>
                <h4 style="text-align: center; color:black;"> COMENTARIOS </h4>
                <div class="comments">
                    <div class="comment" style="border: 2px solid darkgrey;">
                        <button class="denunciaComentario" style="border:none; background:none; float: right;">❗</button>
                        <h3 class="nombreComentario" style="color:black"> Nombre: Pedro </h3>
                        <p class="contenidoComentario" style="color: black; font-size: 13px;"> Hermoso el ejemplo. </p>
                        <span class="fechaComentario" style="color:darkgrey;right: 10%;position: absolute;"> 2/8/2009 9:15AM </span>
                    </div>
                    <br>
                    <div class="comment" style="border: 2px solid darkgrey;">
                        <button class="denunciaComentario" style="border:none; background:none; float: right;">❗</button>
                        <h3 class="nombreComentario" style="color:black"> Nombre: Anastasio </h3>
                        <p class="contenidoComentario" style="color: black; font-size: 13px;"> Hermoso el ejemplo. </p>
                        <span class="fechaComentario" style="color:darkgrey;right: 10%;position: absolute;"> 2/8/2009 9:15AM </span>
                    </div>
                    <br>
                    <div class="comment" style="border: 2px solid darkgrey;">
                        <button class="denunciaComentario" style="border:none; background:none; float: right;">❗</button>
                        <h3 class="nombreComentario" style="color:black"> Nombre: Anacleto </h3>
                        <p class="contenidoComentario" style="color: black; font-size: 13px;"> Hermoso el ejemplo. </p>
                        <span class="fechaComentario" style="color:darkgrey;right: 10%;position: absolute;"> 2/8/2009 9:15AM </span>
                    </div>
                    <br>
                    <div class="comment" style="border: 2px solid darkgrey;">
                        <button class="denunciaComentario" style="border:none; background:none; float: right;">❗</button>
                        <h3 class="nombreComentario" style="color:black"> Nombre: Random </h3>
                        <p class="contenidoComentario" style="color: black; font-size: 13px;"> Hermoso el ejemplo. </p>
                        <span class="fechaComentario" style="color:darkgrey;right: 10%;position: absolute;"> 2/8/2009 9:15AM </span>
                    </div>
                    <br>
                    
                </div>
            </div>
            
        </div>
    </section>


    <footer>
        <div>
            <div class="">
                <ul>
                    <li>Contacto:</li>
                    <li>Envianos un email: empresa.bytewizards.3bg@gmail.com</li>
                    <li>Teléfono: xxx-xx-xx</li>
                </ul>
            </div>
            <div class="">
                <ul>
                    <li>Cliente:</li>
                    <li>DGETP-UTU</li>
                    <li>Teléfono: 2208 9891</li>
                </ul>
            </div>
            <div class="">
                <ul>
                    <li>Equipo de Desarrollo:</li>
                    <li>ByteWizards Corporation</li>
                </ul>
            </div>
        </div>
    </footer>
</body>
<script src="main.js"></script>
<script src="perfilUsu.js"></script>
<script src="iniciarSesionUsu.js"></script>
<script src="commentary.js"></script>
<script src="jquery-3.7.1.min.js"></script>
</html>

<!-- <div class="">
    <a href="#"><span class="material-symbols-outlined">passkey</span></a>
    <a href="#"><span class="material-symbols-outlined">shopping_cart</span></a>
</div> -->


<!-- <span class="material-symbols-outlined">menu</span> -->