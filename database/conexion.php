<?php
error_reporting(E_ALL); // Mostrar errores
ini_set('display_errors', 1);

$servidor = "localhost";
$usuario = "root";
$clave = "";
$baseDatos = "psicologos_online";

// Conectar a MySQL
$conn = new mysqli($servidor, $usuario, $clave, $baseDatos);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error en la conexión: " . $conn->connect_error);
} else {
    echo "✅ Conexión exitosa a la base de datos.";
}
?>

