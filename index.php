<?php session_start(); ?>
<?php include("database/conexion.php"); ?>

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

    <!-- logo en miniatura -->
    <link rel="Icon" href="img/brain-solid.svg">

    <!-- ICONSOUT CDN -->
    <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php
    $pagina_actual = 'inicio';
    include('includes/header.php');
    ?>

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
                    <button class="btn btn6" onclick="location.href='contacto.php#cita'">Pide tu cita</button>
                </div>
            </div>
        </div>
    </section>

    <section class="intro">
        <div class="intro_container">
            <div class="intro_info">

                <div class="intro_info_text">
                    <p class="subtitulo">Psicología</p>
                    <h1>Centro MindCore</h1>
                    <p>La mayoría de las personas somos conscientes de nuestros desequilibrios emocionales o problemas
                        personales, que nos hacen pensar en la posibilidad de pedir ayuda psicológica, sin embargo,
                        tomar esta decisión no resulta fácil.</p>

                    <p>Decidir por sí mismos, buscar información y elegir al profesional adecuado es un buen comienzo
                        que facilitará el autoanálisis y la implicación activa en el proceso de terapia.
                        Progresivamente, la mayoría de nuestros clientes solicitan la ayuda psicológica de manera
                        voluntaria.</p>
                    <button class="btn btn5" onclick="location.href='contacto.php'">Más Sobre Nostros</button>
                </div>
                <div class="intro_info_img">
                    <img src="img/despacho.png" alt="despacho psicología">
                </div>
            </div>
            <div class="intro_cards">
                <div class="intro_cards_container">
                    <div class="intro_card card1">
                        <p class="subtitulo">
                            Otros
                        </p>
                        <i class="fa-solid fa-hexagon-nodes"></i>
                        <h4>Neuropsicología</h4>
                    </div>
                    <div class="intro_card card2">
                        <p class="subtitulo">
                            Psicología
                        </p>
                        <i class="fa-solid fa-scale-balanced"></i>
                        <h4>Psicología Jurídica</h4>
                    </div>
                    <div class="intro_card card3">
                        <p class="subtitulo">
                            Psicología
                        </p>
                        <i class="fa-solid fa-hands-holding-child"></i>
                        <h4>Psicología Infantil y Juvenil</h4>
                    </div>
                    <div class="intro_card card4">
                        <p class="subtitulo">
                            Psicología
                        </p>
                        <i class="fa-solid fa-user-group"></i>
                        <h4>Psicología Adultos</h4>
                    </div>
                    <div class="intro_card card5">
                        <p class="subtitulo">
                            Otros
                        </p>
                        <i class="fa-solid fa-bullhorn"></i>
                        <h4>Logopedia</h4>
                    </div>
                </div>
                </di>
            </div>
    </section>



    <!-- TARJETAS EN ESCALERA -->
    <section class="tarjetas_escalera animar-aparicion">
        <div class="tarjeta t1">
            <h3>SERVICIOS</h3>
            <p>Desde terapia individual hasta acompañamiento familiar, descubre cómo te ayudamos a reconectar contigo
                mismo.</p>
            <button class="btn" onclick="location.href='profesionales.php'">Ver servicios</button>
        </div>
        <div class="tarjeta t2">
            <h3>TERAPEUTAS</h3>
            <p>Psicólogos colegiados con amplia experiencia en salud emocional y mental, listos para acompañarte.</p>
            <button class="btn2" onclick="location.href='profesionales.php'">Conócenos</button>
        </div>
        <div class="tarjeta t3">
            <h3>TESTIMONIOS</h3>
            <p>Historias reales de superación contadas por quienes decidieron dar el primer paso hacia el cambio.</p>
            <button class="btn3" onclick="location.href='contacto.php'">Leer más</button>
        </div>
    </section>

    <!-- SOBRE NOSOTROS -->
    <section class="sobre_nosotros animar-aparicion">

        <div class="sobre_img">
            <img src="img/sobre_nosotros.png" alt="Sobre nosotros">
        </div>
        <div class="sobre_texto">
            <p class="subtitulo">TE AYUDAMOS</p>
            <h2>UN ESPACIO PARA TU BIENESTAR EMOCIONAL</h2>
            <p>En MindCore, creemos que cada persona merece un espacio donde sentirse escuchada y comprendida.
                Nuestro
                enfoque es humano, ético y comprometido con el proceso de cambio.</p>
            <p>Contamos con profesionales capacitados en distintas áreas de la salud mental que trabajan contigo
                para
                superar obstáculos, sanar heridas y redescubrir tu fuerza interior.</p>


            <div class="sobre_datos">
                <div class="sobre_datos_container">
                    <div class="sobre_dato">
                        <h2>200</h2>
                        <p>Pacientes al año</p>
                    </div>
                    <div class="sobre_dato">
                        <h2>7</h2>
                        <p>Profesionales</p>
                    </div>
                    <div class="sobre_dato">
                        <h2>15</h2>
                        <p>Años de experiencia</p>
                    </div>
                    <div class="sobre_dato">
                        <h2>2500</h2>
                        <p>Pacientes satisfechos</p>
                    </div>
                </div>

            </div>
            <button class="btn  btn5" onclick="location.href='contacto.php'">Contáctanos</button>
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
    <section class="ultimos_articulos animar-aparicion">
        <p class="subtitulo">BLOG Y NOTICIAS</p>
        <h2>Últimos artículos</h2>

        <div class="articulos-grid-5">
            <?php
            $sql = "SELECT a.id, a.titulo, a.resumen, d.nombre, d.apellidos
                FROM articulos a
                JOIN users_data d ON a.id_psicologo = d.idUser
                ORDER BY a.fecha DESC
                LIMIT 4";

            $resultado = $conexion->query($sql);
            $colores = ['beige', 'naranja'];
            $i = 0;

            while ($articulo = $resultado->fetch_assoc()):
                $colorClase = $colores[$i % 2];
                ?>
                <article class="articulo-5 <?= $colorClase ?>" style="animation-delay: <?= $i * 0.2 ?>s;">
                    <h3><?= htmlspecialchars($articulo['titulo']) ?></h3>
                    <p><?= htmlspecialchars($articulo['resumen']) ?></p>
                    <small><?= htmlspecialchars($articulo['nombre'] . " " . $articulo['apellidos']) ?></small>
                    <button onclick="location.href='ver_articulo.php?id=<?= $articulo['id'] ?>'" class="btn-leer">Leer
                        más</button>
                </article>
                <?php $i++; endwhile; ?>

            <!-- Tarjeta especial: Ver más -->
            <article class="articulo-5 ver-mas" onclick="location.href='blog.php'"
                style="animation-delay: <?= $i * 0.2 ?>s;">
                <div>
                    <h3>Ver más artículos</h3>
                    <p>Explora todos nuestros contenidos</p>
                    <span class="flecha">➜</span>
                </div>
            </article>
        </div>
    </section>




    <!-- FRASE FINAL -->
    <section class="frase-final animar-aparicion">
        <p>“Lo que no estás cambiando, lo estás escogiendo.”</p>
    </section>

    <?php include("includes/footer.php"); ?>

<script src="js/main.js"></script>
</body>

</html>