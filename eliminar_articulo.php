<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["idUser"]) || $_SESSION["rol"] != "psicologo") {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET["id"])) {
    $idArticulo = $_GET["id"];
    $sql = "DELETE FROM articulos WHERE idArticulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idArticulo);
    
    if ($stmt->execute()) {
        echo "Artículo eliminado.";
    } else {
        echo "Error al eliminar.";
    }
}
?>
<a href="articulos_admin.php">Volver</a>
