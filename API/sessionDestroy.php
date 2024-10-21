<?php
    session_start();
    session_destroy();
    echo "Sesiones destruidas con exito";
    header("Location: http://localhost/bytewizards/interfaz/index.php");
?>