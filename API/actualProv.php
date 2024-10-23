<?php 
session_start();
$nombreEmpresa = $_SESSION['empresas'][0]['nombre'];
echo json_encode(['nombreEmpresa' => $nombreEmpresa]); // Enviando un objeto JSON
?>
