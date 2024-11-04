<?php 
session_start(); 
if (empty($_SESSION['empresas'])) {
    header("Location: loginProveedores.php");
}
if (!empty($_SESSION['empresas'])) {
    require("../API/ConexionDB.php");

    // Configuración de la base de datos
    $host = 'localhost';
    $dbname = 'weshop';
    $username = 'root';
    $password = ''; // Cambia la contraseña si es necesario

    $conexionDB = new ConexionDB($host, $dbname, $username, $password);
    $pdo = $conexionDB->getPDO();
    $stmt = $pdo->prepare("SELECT * FROM empresa WHERE id_empresa = ?");
    $stmt->execute([$_SESSION['empresas'][0]['id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        $_SESSION['empresas'][0] = [ 
            'id' => $usuario['id_empresa'],
            'nombre' => $usuario['nombre_empresa'],
            'correo' => $usuario['mail_empresa'],
            'direccion' => $usuario['ubicacion_fisica'],
            'numero' => $usuario['telefono_empresa'],
            'habilitacion' => $usuario['habilitacion_empresa']
        ];
    }
}
if ($_SESSION['empresas'][0]['habilitacion'] == "Deshabilitado"){
    header("Location: noIniciadoProv.php");
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
    <!-- Esta en el body debido a que se desea hacer que la variable este al alcance de TODOS los archivos. -->
    <script>
        var nombreEmpresa = "<?php echo $_SESSION['empresas'][0]['nombre']; ?>";
        console.log(nombreEmpresa); 
        
    </script>

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
                    <button type="submit" class="material-symbols-outlnied">
                        search
                    </button>
                </form>

                <div class="icons">
                    <button alt="iniciarSesion" class="btnLoggin" onclick="toggleLoggin()"> <span class="material-symbols-outlined">passkey</span> </button>
                </div>
            </nav>
        </div>
        <div class="blackbar"> ENVÍO Y DEVOLUCIONES GRATIS </div>
    </header>
    <main>
        <p><a href="historialProveedores.php" style='color: #007BFF;'>¿Desea ver su historial de ventas? ¡Presione aquí!</a></p>
        <!--<Añadir Productos>-->
           <br>
            <div class="entradaProducto">
                <button alt="añadirProducto" class="btnAddProduct" onclick="toggleAñadirProducto()"> <span class="addProductADD">+</span> Añadir Productos </button>
            </div>
        

        <div class="flexCenter">
            <h1 class="categoryName">CATALOGO</h1>
        </div>
        <div class="renderZone">
        </div>
        <br>

        
    </main>
    <section class="productAdd inactive">
        <div class="productAdd-container">
            <div class="productAdd__title">
                <button alt="añadirProducto" class="btnLoggin" onclick="toggleAñadirProducto()"> 
                    <span class="material-symbols-outlined closeLogin">close</span>
                </button>      
                <h1 id="addProductTitle">Añadir Productos</h1>
            </div>
            <form id="productForm">
                <label for="nombreProducto">Nombre del Producto:</label>
                <input type="text" id="nombreProducto" name="nombreProducto" required>
                <label for="stockProducto">STOCK Inicial:</label>
                <input type="number" id="stockProducto" name="stockProducto" required>
                <label for="addProductImage">Imagen:</label>
                <input type="file" id="addProductImage" name="addProductImage" required>
                <label for="precioProducto">Precio del Producto:</label>
                <input type="number" id="precioProducto" name="precioProducto" step="0.01" min="0" required>
                <label for="condicionProducto">Condición del Producto:</label>
                <select id="condicionProducto" name="condicionProducto" required>
                    <option value="Primera Mano">Primera Mano</option>
                    <option value="Segunda Mano">Segunda Mano</option>
                </select>
                <label for="categoriaProducto">Categoria del Producto:</label>
                <select id="categoriaProducto" name="categoriaProducto" required>
                    <option value="tecnologia">Tecnologia</option>
                    <option value="joyeria">Joyeria</option>
                    <option value="ropa">Ropa</option>
                    <option value="animales">Animales</option>
                    <option value="juegos">Juegos</option>
                    <option value="otros">Otros</option>
                </select>
                <label for="descripcionProducto">Descripcion del Producto por unidad:</label>
                <textarea id="descripcionProducto" name="descripcionProducto" required></textarea>
                <button type="submit" class="continueAddProduct">Añadir Producto</button>
            </form>
        </div>
    </section>

    <section class="loggin inactive">
        
        <div class="login-container">
            <div class="loggin__title">
                <button alt="carrito" class="btnLoggin" onclick="toggleLoggin()"> <span class="material-symbols-outlined closeLogin">close</span> </button>      
                <h1 id="logintitulo">Perfil</h1>
            </div>
            
            <form action id="perfilUsu">
                        <!-- zona de actualizacion -->
                <br>
                <h3 style="color: black;"> Su id de empresa: <?php echo $_SESSION['empresas'][0]['id']; ?></h3>
                <label for="cambiarNombre" style="color: black;"> Nombre: <?php echo $_SESSION['empresas'][0]['nombre']; ?> </label>
                <input type="text" id="cambiarNombre" name="cambiarNombre" required placeholder="Cambiar nombre..." value="<?php echo $_SESSION['empresas'][0]['nombre']; ?>">
                <label for="cambiarEmail" style="color: black;">Email: <?php echo $_SESSION['empresas'][0]['correo']; ?></label>
                <input type="text" id="cambiarEmail" name="cambiarEmail" required placeholder="Cambiar correo..." value="<?php echo $_SESSION['empresas'][0]['correo']; ?>">
                <label for="cambiarDirection">Dirección: <?php echo $_SESSION['empresas'][0]['direccion']; ?></label>
                <input type="text" id="cambiarDirection" name="cambiarDirection" required placeholder="Cambiar direccion..." value="<?php echo $_SESSION['empresas'][0]['direccion']; ?>">
                <label for="cambiarNumero">Número de Teléfono: <?php echo $_SESSION['empresas'][0]['numero']; ?></label>
                <input type="number" id="cambiarNumero" name="cambiarNumero" required placeholder="Cambiar telefono..." value="<?php echo $_SESSION['empresas'][0]['numero']; ?>">
                
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
                <p><a href="../API/sessionDestroyProv.php">¿Quieres cerrar sesion? ¡Presione aquí!</a></p>
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
            <button type="submit" class="editarItem">Editar</button>
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
                <br>
                <h4 style="text-align: center; color:black;"> COMENTARIOS </h4>
                <div class="comments">
                    <!-- el ! espara reportar comentarios -->
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

    <section class="productEdit inactive" id="editProductSection">
        <div class="productEdit-container">
          <div class="productEdit__title">
            <button class="btnLoggin" onclick="toggleEditarProducto()"> 
              <span class="material-symbols-outlined closeLogin">close</span> 
            </button>
            <h1 id="editProductTitle">Editar Producto</h1>
          </div>
          <form id="editProductForm">
            <label for="habilitacionProducto">Habilitacion del Producto:</label>
            <select id="habilitacionProducto" name="habilitacionProducto" required>
                <option value="Habilitado">Habilitado</option>
                <option value="Deshabilitado">Deshabilitado</option>
            </select>
            <input type="hidden" id="editProductId" name="editProductId">
            <label for="editNombreProducto">Nombre del Producto:</label>
            <input type="text" id="editNombreProducto" name="editNombreProducto" required>
            <label for="editStockProducto">STOCK:</label>
            <input type="number" id="editStockProducto" name="editStockProducto" required>
            <label for="editProductImage">Imagen:</label>
            <input type="file" id="editProductImage" name="editProductImage">
            <label for="editPrecioProducto">Precio del Producto:</label>
            <input type="number" id="editPrecioProducto" name="editPrecioProducto" step="0.01" min="0" required>
            <label for="editCondicionProducto">Condición del Producto:</label>
            <select id="editCondicionProducto" name="editCondicionProducto" required>
              <option value="Primera Mano">Primera Mano</option>
              <option value="Segunda Mano">Segunda Mano</option>
            </select>
            <label for="editCategoriaProducto">Categoria del Producto:</label>
            <select id="editCategoriaProducto" name="editCategoriaProducto" required>
              <option value="tecnologia">Tecnologia</option>
              <option value="joyeria">Joyeria</option>
              <option value="ropa">Ropa</option>
              <option value="animales">Animales</option>
              <option value="otros">Otros</option>
              <option value="juegos">Juegos</option>
            </select>
            <label for="editDescripcionProducto">Descripcion del Producto:</label>
            <textarea id="editDescripcionProducto" name="editDescripcionProducto" required></textarea>
            <button type="submit" class="continueAddProduct">Guardar Cambios</button>
          </form>
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

<script src="mainProveedores.js"></script>
<script src="perfilProv.js"></script>
<script src="commentary.js"></script>
<script src="jquery-3.7.1.min.js"></script>

</html>

