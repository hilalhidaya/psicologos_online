<?php include("database/conexion.php"); ?>
<!DOCTYPE html>
<html lang="en">

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

    <!-- se utiliza para asegurar que las páginas web se rendericen correctamente en las versiones más recientes del navegador -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- logo en miniatura -->
    <link rel="Icon" href="img/brain-solid.svg">

    <!-- ICONSOUT CDN -->
    <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>

</head>
<?php
include('includes/header.php');
?>

<body>



    <section class="profesionales_portada" data-aos="fade-down">
        <div class="profesionales_portada_container" data-aos="zoom-in">
            <i class="fa-solid fa-brain"></i>
            <h1>TRABAJAMOS PARA AYUDARTE</h1>
            <p>Conoce a nuestros profesionales especializados. Psicología para adultos, adolescentes y niños</p>
        </div>
    </section>

    <section class="profesionales">
        <div class="profesionales_container">
            <div class="profesionales_txt" data-aos="fade-up">
                <p class="subtitulo">MindCore</p>
                <h1>Nuestros Profesionales</h1>
                <p>La base de un buen servicio es confiar en un profesional cualificado que entienda lo que el paciente
                    necesita.</p>
            </div>

            <div class="grid_psicologos">

                <div class="psicologo_card"  data-aos="fade-up" data-aos-delay="0">
                    <img src="img/psicologo6.png" alt="Psicólogo Marco Silva">
                    <div class="info_basica">
                        <h3>Marco Silva</h3>
                        <p>Psicoterapia Integral</p>
                    </div>
                    <div class="info_hover">
                        <p>Atención terapéutica integral con enfoque humanista.</p>
                        <button class="btn btn3">Saber más</button>
                    </div>
                </div>

                <div class="psicologo_card"  data-aos="fade-up" data-aos-delay="100">
                    <img src="img/psicologa1.png" alt="Psicóloga Ana López">
                    <div class="info_basica">
                        <h3>Ana López</h3>
                        <p>Psicología Infantil</p>
                    </div>
                    <div class="info_hover">
                        <p>Especializada en desarrollo emocional infantil y terapia con familias.</p>
                        <button class="btn btn3">Saber más</button>
                    </div>
                </div>

                <div class="psicologo_card" data-aos="fade-up" data-aos-delay="200">
                    <img src="img/psicologa3.png" alt="Psicóloga Mei Tanaka">
                    <div class="info_basica">
                        <h3>Mei Tanaka</h3>
                        <p>Psicología Adolescente</p>
                    </div>
                    <div class="info_hover">
                        <p>Acompañamiento psicológico para adolescentes y jóvenes.</p>
                        <button class="btn btn3">Saber más</button>
                    </div>
                </div>

                <div class="psicologo_card" data-aos="fade-up" data-aos-delay="300">
                    <img src="img/psicologa2.png" alt="Psicóloga Clara Ruiz">
                    <div class="info_basica">
                        <h3>Clara Ruiz</h3>
                        <p>Psicología Clínica</p>
                    </div>
                    <div class="info_hover">
                        <p>Enfoque en ansiedad, autoestima y procesos de cambio personal.</p>
                        <button class="btn btn3">Saber más</button>
                    </div>
                </div>

                <div class="psicologo_card" data-aos="fade-up" data-aos-delay="400">
                    <img src="img/psicologa4.png" alt="Psicóloga Laura Méndez">
                    <div class="info_basica">
                        <h3>Laura Méndez</h3>
                        <p>Psicología Adultos</p>
                    </div>
                    <div class="info_hover">
                        <p>Especialista en duelo, ansiedad y relaciones interpersonales.</p>
                        <button class="btn btn3">Saber más</button>
                    </div>
                </div>

                <div class="psicologo_card" data-aos="fade-up" data-aos-delay="500">
                    <img src="img/psicologo5.png" alt="Psicólogo Javier Ortega">
                    <div class="info_basica">
                        <h3>Javier Ortega</h3>
                        <p>Psicología General</p>
                    </div>
                    <div class="info_hover">
                        <p>Apoyo psicológico en contextos legales y forenses.</p>
                        <button class="btn btn3">Saber más</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="seccion_dudas" data-aos="fade-up">
        <div class="dudas_container"  data-aos="zoom-in">
            <i class="fa-solid fa-question-circle"></i>
            <h2>¿Tienes dudas?</h2>
            <p>No estás solo/a. Si algo no te queda claro o simplemente quieres hablar con nosotros, estamos aquí para
                escucharte.</p>
            <button class="btn btn5 btn6" onclick="location.href='contacto.php'">Ponte en contacto</button>
        </div>
    </section>


    <?php include("includes/footer.php"); ?>

    <!-- Librería AOS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>

</html>