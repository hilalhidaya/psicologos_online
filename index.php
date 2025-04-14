<?php include('database/conexion.php'); ?>

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

    <!-- se utiliza para asegurar que las páginas web se rendericen correctamente en las versiones más recientes del navegador -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- ICONSOUT CDN -->
    <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php include("includes/header.php"); ?>

    <!-- PORTADA/HERO -->
    <section class="hero">
        <div class="hero_container animar-aparicion">
            <div class="hero-left">
                <img src="img/portada.png" alt="Terapia ilustración">
            </div>
            <div class="hero-right">
                <h1>Tu salud mental importa, y tu cambio empieza hoy</h1>
                <p>No importa dónde estés, la ayuda está al alcance de tu mano. Conectamos contigo desde cualquier
                    rincón de España, a través de terapia online o presencial, con los mejores profesionales para cuidar
                    tu bienestar.</p>
                <div class="hero-buttons">
                    <button class="btn" onclick="location.href='profesionales.php#servicios'">Servicios</button>
                    <button class="btn2" onclick="location.href='contacto.php#cita'">Pide tu cita</button>
                </div>
            </div>
        </div>
    </section>

    <!-- TARJETAS EN ESCALERA -->
    <section class="tarjetas-escalera animar-aparicion">
        <div class="tarjeta t1">
            <h3>SERVICIOS</h3>
            <p>Desde terapia individual hasta acompañamiento familiar, descubre cómo te ayudamos a reconectar contigo
                mismo.</p>
            <button class="btn" onclick="location.href='profesionales.php#servicios'">Ver servicios</button>
        </div>
        <div class="tarjeta t2">
            <h3>TERAPEUTAS</h3>
            <p>Psicólogos colegiados con amplia experiencia en salud emocional y mental, listos para acompañarte.</p>
            <button class="btn2" onclick="location.href='profesionales.php'">Conócenos</button>
        </div>
        <div class="tarjeta t3">
            <h3>TESTIMONIOS</h3>
            <p>Historias reales de superación contadas por quienes decidieron dar el primer paso hacia el cambio.</p>
            <button class="btn3" onclick="location.href='contacto.php#testimonios'">Leer más</button>
        </div>
    </section>

    <!-- SOBRE NOSOTROS -->
    <section class="sobre_nosotros animar-aparicion">

        <div class="sobre-img">
            <img src="img/sobre_nosotros.png" alt="Sobre nosotros">
        </div>
        <div class="sobre-texto">
            <h2>UN ESPACIO PARA TU BIENESTAR EMOCIONAL</h2>
            <p>En MindCore, creemos que cada persona merece un espacio donde sentirse escuchada y comprendida.
                Nuestro
                enfoque es humano, ético y comprometido con el proceso de cambio.</p>
            <p>Contamos con profesionales capacitados en distintas áreas de la salud mental que trabajan contigo
                para
                superar obstáculos, sanar heridas y redescubrir tu fuerza interior.</p>
            <button class="btn" onclick="location.href='contacto.php'">Contáctanos</button>
        </div>

    </section>

    <!-- FRASE REFLEXIVA -->
    <section class="frase animar-aparicion">
        <div class="frase_container">
            <blockquote>
                <p>“A veces, lo más valiente que puedes hacer es permitirte ser escuchado, no para encontrar respuestas,
                    sino para dejar de cargar con todo en silencio.”</p>
                <footer>– Anónimo</footer>
            </blockquote>
        </div>
    </section>

    <!-- PROGRAMAR CITA -->
    <section class="cita animar-aparicion">
        <div class="cita_container">
            <div class="cita-texto">
                <h2>EL MOMENTO DE EMPEZAR ES AHORA</h2>
                <p>No necesitas tocar fondo para comenzar a sanar. Tomar la decisión de pedir ayuda es valiente, y en
                    MindCore estamos para acompañarte en cada paso.
                    Nuestro equipo está preparado para ayudarte a gestionar tus emociones, encontrar claridad y sentirte
                    en
                    paz contigo mismo.
                    Recuerda que si estás en una situación crítica o de emergencia, por favor contacta con el 112
                    inmediatamente. Tu salud emocional es tan importante como tu salud física.</p>
                <button class="btn2" onclick="location.href='contacto.php#cita'">Programa tu cita</button>
            </div>
            <div class="cita-img">
                <img src="img/reloj_arena.png" alt="Reloj de arena">
            </div>
        </div>
    </section>

    <!-- ÚLTIMOS ARTÍCULOS -->
    <section class="ultimos-articulos animar-aparicion">
        <h2>Últimos artículos</h2>
        <div class="articulos-grid">
            <?php
            $sql = "SELECT a.id, a.titulo, a.resumen, p.nombre AS autor
            FROM articulos a
            JOIN psicologos p ON a.id_psicologo = p.id
            ORDER BY a.fecha DESC
            LIMIT 6";

            $resultado = $conexion->query($sql);

            while ($articulo = $resultado->fetch_assoc()):
                ?>
                <article class="articulo">
                    <h3><?= htmlspecialchars($articulo['titulo']) ?></h3>
                    <p><?= htmlspecialchars($articulo['resumen']) ?></p>
                    <small>Por <?= htmlspecialchars($articulo['autor']) ?></small><br>
                    <button class="btn3" onclick="location.href='ver_articulo.php?id=<?= $articulo['id'] ?>'">Leer
                        más</button>
                </article>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- FRASE FINAL -->
    <section class="frase-final animar-aparicion">
        <p>“Lo que no estás cambiando, lo estás escogiendo.”</p>
    </section>

    <?php include("includes/footer.php"); ?>


</body>

</html>