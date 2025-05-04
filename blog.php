<?php
include("database/conexion.php");

// Corregido: ahora hacemos JOIN a users_data, no a psicologos
$sql = "SELECT a.id, a.titulo, a.imagen, a.fecha, a.resumen, d.nombre, d.apellidos
        FROM articulos a 
        JOIN users_data d ON a.id_psicologo = d.idUser
        ORDER BY a.fecha DESC";

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MindCore</title>

    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="js/scripts.js" defer></script>
    <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>
    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="Icon" href="img/brain-solid.svg">
</head>

<body>
    <?php
    $pagina_actual = 'blog';
    include('includes/header.php');
    ?>

    <section class="portada_blog" data-aos="fade-down">
        <div class="portada_blog_container" data-aos="zoom-in">
            <i class="fa-solid fa-brain"></i>
            <h1>EXPLORA NUESTROS ARTÍCULOS</h1>
            <p>Descubre información valiosa y consejos prácticos sobre salud mental, bienestar emocional y desarrollo
                personal.</p>
        </div>
    </section>

    <section class="articulos">
        <div class="articulos_container">
            <div class="articulos_title" data-aos="fade-up">
                <p class="subtitulo">NOVEDADES</p>
                <h2>Últimos Artículos</h2>
                <p>Sumérgete en nuestros artículos más recientes y amplía tu conocimiento sobre salud mental.</p>
            </div>
            <div class="articulos_list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="articulo_item" data-aos="fade-up">
                        <?php if (!empty($row["imagen"])): ?>
                            <img src="img/articulos/<?= htmlspecialchars($row["imagen"]) ?>"
                                alt="<?= htmlspecialchars($row["titulo"]) ?>">
                        <?php endif; ?>
                        <div class="articulo_item_info">
                            <h3><?= htmlspecialchars($row["titulo"]) ?></h3>
                            <p class="autor_fecha"> <?= htmlspecialchars($row["nombre"] . " " . $row["apellidos"]) ?> -
                                <?= $row["fecha"] ?>
                            </p>
                            <p><?= nl2br(htmlspecialchars(substr($row["resumen"], 0, 300))) ?>...</p>
                            <a class="btn btn5" href="ver_articulo.php?id=<?= $row["id"] ?>">Leer más</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <section class="llamada_accion" data-aos="fade-up">
        <div class="llamada_accion_container">
            <div class="llamada_accion_left" data-aos="fade-right" data-aos-delay="100">
                <h2>¿Listo para dar el siguiente paso?</h2>
                <p>Contáctanos y descubre cómo podemos ayudarte a mejorar tu bienestar emocional.</p>
                <button class="btn btn4" onclick="location.href='contacto.php#cita'">Pide tu cita</button>
            </div>
            <div class="llamada_accion_right" data-aos="fade-left" data-aos-delay="200">
                <ul>
                    <li><i class="fa-solid fa-check"></i> Agenda una cita en línea en menos de 2 minutos.</li>
                    <li><i class="fa-solid fa-check"></i> Elige al profesional que mejor se adapte a ti.</li>
                    <li><i class="fa-solid fa-check"></i> Recibe acompañamiento personalizado y cercano.</li>
                    <li><i class="fa-solid fa-check"></i> Empieza tu camino hacia una vida con mayor equilibrio
                        emocional.</li>
                </ul>
            </div>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>
</body>

<!-- AOS Animations -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true
  });
</script>

</html>