<?php
include("database/conexion.php");

$sql = "SELECT a.id, a.titulo, a.imagen, a.fecha, p.nombre 
        FROM articulos a 
        JOIN psicologos p ON a.id_psicologo = p.id 
        ORDER BY a.fecha DESC";

$result = $conexion->query($sql);
?>


<!DOCTYPE html>
<html lang="es">

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MindCore</title>

        <link rel="stylesheet" href="css/style.css">

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="js/scripts.js" defer></script>

        <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>

        <!-- se utiliza para asegurar que las páginas web se rendericen correctamente en las versiones más recientes del navegador -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- logo en miniatura -->
        <link rel="Icon" href="img/brain-solid.svg">

        <!-- ICONSOUT CDN -->
        <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>


    </head>

<body>
    <?php
    $pagina_actual = 'blog';
    include('includes/header.php');
    ?>

    <section class="portada_blog">
        <div class="portada_blog_container">
            <i class="fa-solid fa-brain"></i>
            <h1>EXPLORA NUESTROS ARTÍCULOS</h1>
            <p>Descubre información valiosa y consejos prácticos sobre salud mental, bienestar emocional y desarrollo
                personal.</p>
        </div>
    </section>

    <section class="articulos">
        <div class="articulos_container">
            <div class="articulos_title">
                <h2>Últimos Artículos</h2>
                <p>Sumérgete en nuestros artículos más recientes y amplía tu conocimiento sobre salud mental.</p>
            </div>
            <div class="articulos_list">

                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="articulo_item">
                        <h3><?php echo $row["titulo"]; ?></h3>
                        <p>Por: <?php echo $row["nombre"] . " " . $row["apellidos"]; ?> - Fecha:
                            <?php echo $row["fecha"]; ?>
                        </p>
                        <img src="img/articulos/<?php echo $row["imagen"]; ?>" width="200"
                            alt="<?php echo $row["titulo"]; ?>">
                        <p><?php echo nl2br(substr(strip_tags($row["contenido"]), 0, 300)); ?>...</p>
                        <a class="btn3" href="ver_articulo.php?id=<?php echo $row["id"]; ?>">Leer más</a>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>

    <section class="llamada_accion">
        <div class="llamada_accion_container">
            <div class="llamada_accion_left">
                <h2>¿Listo para dar el siguiente paso?</h2>
                <p>Contáctanos y descubre cómo podemos ayudarte a mejorar tu bienestar emocional.</p>
                <button class="btn  btn4" onclick="location.href='contacto.php#cita'">Pide tu cita</button>
            </div>
            <div class="llamada_accion_right">
                <ul>
                    <li>Agenda una cita en línea en menos de 2 minutos.</li>
                    <li>Elige al profesional que mejor se adapte a ti.</li>
                    <li>Recibe acompañamiento personalizado y cercano.</li>
                    <li>Empieza tu camino hacia una vida con mayor equilibrio emocional.</li>
                </ul>
            </div>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>
</body>

</html>