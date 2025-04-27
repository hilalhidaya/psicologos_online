<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["idUser"]) || $_SESSION["rol"] != "psicologo") {
    header("Location: ../login.php");
    exit();
}

$idPsicologo = $_SESSION["idUser"];

$sql = "SELECT idArticulo, titulo, fecha FROM articulos WHERE idPsicologo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idPsicologo);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Artículos</title>
</head>
<body>
    <h2>Mis Artículos</h2>
    <a href="crear_articulo.php">Nuevo Artículo</a>
    <table border="1">
        <tr>
            <th>Título</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["titulo"]; ?></td>
                <td><?php echo $row["fecha"]; ?></td>
                <td>
                    <a href="../ver_articulo.php?id=<?php echo $row["idArticulo"]; ?>">Ver</a>
                    <a href="eliminar_articulo.php?id=<?php echo $row["idArticulo"]; ?>">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
