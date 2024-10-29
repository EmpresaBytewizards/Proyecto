<?php 
session_start(); 
if (empty($_SESSION['staffs'])) {
    header("Location: loginStaff.php");
}
if (!empty($_SESSION['staffs'])) {
    require("../API/ConexionDB.php");

    // Configuración de la base de datos
    $host = 'localhost';
    $dbname = 'backoffice';
    $username = 'root';
    $password = ''; // Cambia la contraseña si es necesario

    $conexionDB = new ConexionDB($host, $dbname, $username, $password);
    $pdo = $conexionDB->getPDO();
    $stmt = $pdo->prepare("SELECT * FROM staff WHERE id_staff = ?");
    $stmt->execute([$_SESSION['staffs'][0]['id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        $_SESSION['staffs'][0] = [ 
            'id' => $usuario['id_staff'],
            'nombre' => $usuario['nombre_staff'],
            'correo' => $usuario['mail_staff'],
            'direccion' => $usuario['ubicacion_staff'],
            'numero' => $usuario['telefono_staff'],
            'tipo' => $usuario['tipo_staff']
        ];
    }
}
if ($_SESSION['staffs'][0]['tipo'] == "Deshabilitado"){
    header("Location: noIniciadoStaff.php");
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
        var nombreStaff = "<?php echo $_SESSION['staffs'][0]['nombre']; ?>";
        console.log(nombreStaff); 
        
    </script>
    

    <header> 
        <div class="header__top">
            <div class="logo__container">
                <img id="logo_pagina" src="tienda/Logopagina tr borde.png" data-category="CATALOG">
            </div>
            <nav style="display:flex;justify-content: end;">
                <div class="icons">
                    <button alt="iniciarSesion" class="btnLoggin" onclick="toggleLoggin()"> <span class="material-symbols-outlined">passkey</span> </button>
                </div>
            </nav>
        </div>
        <div class="blackbar"> ENVÍO Y DEVOLUCIONES GRATIS </div>
    </header>
    <main>
        

        <div class="flexCenter">
            <h1 class="categoryName">BACKOFFICE</h1>
        </div>
        <?php
        if ($_SESSION['staffs'][0]['tipo'] != "Organizador"){     
        ?>
        <section class="admin-section" style="margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="font-size: 24px; color: #333;">Productos</h2>
            <input type="text" id="buscarArticulos" placeholder="Buscar objetos por ID" onkeyup="filterList('articulosTabla', 'buscarArticulos')" style="color: black; width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;">
            <table id="articulosTabla" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Producto</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Proveedor</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Nombre</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los productos cargaran acá -->
                </tbody>
            </table>
        </section>
        
        <?php
        }
        if ($_SESSION['staffs'][0]['tipo'] != "Organizador"){     
        ?>
        <section class="admin-section" style="margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="font-size: 24px; color: #333;">Proveedores</h2>
            <input type="text" id="buscarProveedores" placeholder="Buscar proveedor por ID" onkeyup="filterList('proveedoresTabla', 'buscarProveedores')" style="color: black; width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;">
            <table id="proveedoresTabla" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Nombre</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Correo</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Teléfono</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Dirección</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los proveedores cargaran aca -->
                </tbody>
            </table>
        </section>

        <?php
        }
        if ($_SESSION['staffs'][0]['tipo'] != "Organizador"){     
        ?>
        <section class="admin-section" style="margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="font-size: 24px; color: #333;">Compradores</h2>
            <input type="text" id="buscarCompradores" placeholder="Buscar usuarios por ID" onkeyup="filterList('compradoresTabla', 'buscarCompradores')" style="color: black; width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;">
            <table id="compradoresTabla" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Nombre</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Correo</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Teléfono</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Dirección</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los compradores cargaran acá -->
                </tbody>
            </table>
        </section>
        <br>

        <?php
        }
        if ($_SESSION['staffs'][0]['tipo'] != "Organizador"){     
        ?>

        <section class="admin-section" style="margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="font-size: 24px; color: #333;">Denuncias</h2>
            <input type="text" id="buscarDenuncias" placeholder="Buscar denuncias por ID" onkeyup="filterList('denunciasTabla', 'buscarDenuncias')" style="color: black; width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;">
            <table id="denunciasTabla" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Denuncia</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Tipo Denunciante</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Denunciante</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Tipo Denunciado</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Denunciado</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Fecha Denuncia</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Estado Denuncia</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las denuncias cargaran acá -->
                </tbody>
            </table>
        </section>
        <br>

        <?php
        }
        if ($_SESSION['staffs'][0]['tipo'] == "Admin"){     
        ?>
        <section class="admin-section" style="margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="font-size: 24px; color: #333;">STAFFs Inferiores</h2>
            <input type="text" id="buscarMod" placeholder="Buscar STAFF por ID" onkeyup="filterList('modTabla', 'buscarMod')" style="color: black; width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;">
            <table id="modTabla" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Nombre</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Correo</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Teléfono</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Dirección</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los STAFFs cargaran acá -->
                </tbody>
            </table>
        </section>
        <br>
        <?php
        }
        ?>


        <?php
        if ($_SESSION['staffs'][0]['tipo'] == "Root"){     
        ?>
        <section class="admin-section" style="margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="font-size: 24px; color: #333;">STAFFs Inferiores</h2>
            <input type="text" id="buscarStaff" placeholder="Buscar STAFF por ID" onkeyup="filterList('staffTabla', 'buscarStaff')" style="color: black; width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;">
            <table id="staffTabla" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Nombre</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Correo</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Teléfono</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Dirección</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los STAFFs cargaran acá -->
                </tbody>
            </table>
        </section>
        <br>
        <?php
        }
        ?>

        <section class="admin-section" style="margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="font-size: 24px; color: #333;">Carritos</h2>
            <input type="text" id="buscarCarrito" placeholder="Buscar carritos por ID" onkeyup="filterList('carritoTabla', 'buscarCarrito')" style="color: black; width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;">
            <table id="carritoTabla" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Carrito</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Usuario</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Fecha Peticion</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Direccion de Envio</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Precio del Carrito</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los Carritos cargaran acá -->
                </tbody>
            </table>
        </section>
        <br>

        <section class="admin-section" style="margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="font-size: 24px; color: #333;">Ventas</h2>
            <input type="text" id="buscarVenta" placeholder="Buscar carritos por ID" onkeyup="filterList('ventaTabla', 'buscarVenta')" style="color: black; width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;">
            <table id="ventaTabla" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Venta</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Carrito</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Proveedor</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">ID Producto</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Fecha Venta</th>
                        <th style="padding: 10px; border: 1px solid #ddd; background-color:rgb(255, 106, 0);">Precio Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los Carritos cargaran acá -->
                </tbody>
            </table>
        </section>
        <br>

    </main>

    <section class="loggin inactive">
        
        <div class="login-container">
            <div class="loggin__title">
                <button alt="carrito" class="btnLoggin" onclick="toggleLoggin()"> <span class="material-symbols-outlined closeLogin">close</span> </button>      
                <h1 id="logintitulo">Perfil</h1>
            </div>
            
            <form action id="perfilUsu">
                
                <br>
                <h3 style="color: black;"> Su id de STAFF es: <?php echo $_SESSION['staffs'][0]['id']; ?></h3>
                <label for="cambiarNombre" style="color: black;">Su nombre de STAFF es: <?php echo $_SESSION['staffs'][0]['nombre']; ?> </label> 
                <input type="text" id="cambiarNombre" name="cambiarNombre" required placeholder="Cambiar nombre..." value="<?php echo $_SESSION['staffs'][0]['nombre']; ?>">
                <label for="cambiarEmail" style="color: black;">Email: <?php echo $_SESSION['staffs'][0]['correo']; ?></label>
                <input type="text" id="cambiarEmail" name="cambiarEmail" required placeholder="Cambiar correo..." value="<?php echo $_SESSION['staffs'][0]['correo']; ?>">
                <label for="cambiarDirection">Direccion: <?php echo $_SESSION['staffs'][0]['direccion']; ?></label>
                <input type="text" id="cambiarDirection" name="cambiarDirection" required placeholder="Cambiar direccion..." value="<?php echo $_SESSION['staffs'][0]['direccion']; ?>">
                <label for="cambiarNumero">Número de Telefono: <?php echo $_SESSION['staffs'][0]['numero']; ?></label>
                <input type="number" id="cambiarNumero" name="cambiarNumero" required placeholder="Cambiar telefono..." value="<?php echo $_SESSION['staffs'][0]['numero']; ?>">
                
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
                <p><a href="../API/sessionDestroyStaff.php">¿Quieres cerrar sesion? ¡Presione aquí!</a></p>
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

<script src="mainStaff.js"></script>
<script src="perfilStaff.js"></script>
<script src="jquery-3.7.1.min.js"></script>

</html>

<!-- <div class="">
    <a href="#"><span class="material-symbols-outlined">passkey</span></a>
    <a href="#"><span class="material-symbols-outlined">shopping_cart</span></a>
</div> -->


<!-- <span class="material-symbols-outlined">menu</span> -->