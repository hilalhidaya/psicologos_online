<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basededatos = "psicologos_online";

$conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
