<?php
session_start();
include("../database/conexion.php");

if (!isset($_SESSION["idUser"]) || $_SESSION["rol"] != "psicologo") {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $idPsicologo = $_SESSION["idUser"];

    // Manejo de la imagen
    $nombreImagen = $_FILES["imagen"]["name"];
    $rutaTemporal = $_FILES["imagen"]["tmp_name"];
    $rutaDestino = "../img/" . $nombreImagen;
    move_uploaded_file($rutaTemporal, $rutaDestino);

    $sql = "INSERT INTO articulos (titulo, imagen, contenido, fecha, idPsicologo) VALUES (?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $titulo, $nombreImagen, $contenido, $idPsicologo);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Artículo publicado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>Error al publicar el artículo.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Artículo</title>
</head>
<body>
    <h2>Publicar Artículo</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="titulo" placeholder="Título del artículo" required>
        <input type="file" name="imagen" accept="image/*" required>
        <textarea name="contenido" placeholder="Escribe el contenido del artículo aquí..." required></textarea>
        <button type="submit">Publicar</button>
    </form>
</body>
</html>
