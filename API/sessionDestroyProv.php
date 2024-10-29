<?php
    session_start();
    session_destroy();
    echo "Sesiones destruidas con exito";
    header("Location: ../interfaz/loginProveedores.php");
?>