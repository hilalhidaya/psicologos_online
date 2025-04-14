<?php
include("database/conexion.php");

// Obtener los artículos publicados
$sql = "SELECT a.idArticulo, a.titulo, a.imagen, a.contenido, a.fecha, u.nombre, u.apellidos 
        FROM articulos a 
        JOIN users u ON a.idPsicologo = u.idUser 
        ORDER BY a.fecha DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Artículos de Psicología</title>
</head>
<body>
    <h2>Artículos de Psicólogos</h2>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <div>
            <h3><?php echo $row["titulo"]; ?></h3>
            <p>Por: <?php echo $row["nombre"] . " " . $row["apellidos"]; ?> - Fecha: <?php echo $row["fecha"]; ?></p>
            <img src="img/<?php echo $row["imagen"]; ?>" width="200">
            <p><?php echo nl2br(substr($row["contenido"], 0, 300)); ?>...</p>
            <a href="ver_articulo.php?id=<?php echo $row["idArticulo"]; ?>">Leer más</a>
        </div>
    <?php } ?>
</body>
</html>
