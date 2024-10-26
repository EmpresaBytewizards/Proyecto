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
        <div class="renderZone">
        </div>
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
                <h3 style="color: black;"> Su id de empresa es: <?php echo $_SESSION['staffs'][0]['id']; ?> <br> Su nombre de empresa es: <?php echo $_SESSION['staffs'][0]['nombre']; ?></h3> 
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
                    <li id="minMin" class="reject"> Minímum 1 letra minuscula. </li>
                    <li id="minNum" class="reject"> Al menos 1 número. </li>
                </ul>
                <input type="password" id="cambiarPassword" name="cambiarPassword" required  placeholder="Cambiar contraseña...">
                <label for="password2">Repita su contraseña:</label>
                <input type="password" id="password2" name="password2" required placeholder="Ingrese la contraseña nuevamente...">
                <span style="color: black;"> Debes llenar todos los espacios para poder actualizar su perfil. </span>
                <button type="submit" class="continueLoggin">Actualizar informacion</button>
                <p><a href="http://localhost/bytewizards/API/sessionDestroyStaff.php">¿Quieres cerrar sesion? ¡Presione aquí!</a></p>
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