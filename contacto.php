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

    <!-- se utiliza para asegurar que las páginas web se rendericen correctamente en las versiones más recientes del navegador -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- logo en miniatura -->
    <link rel="Icon" href="img/brain-solid.svg">

    <!-- ICONSOUT CDN -->
    <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>

</head>
<?php
$pagina_actual = 'contacto';
include('includes/header.php');
?>

<body>

    <!-- SECCIÓN PORTADA -->
    <section class="contacto_portada"   data-aos="fade-down">
        <div class="contacto_portada_container">
            <i class="fa-solid fa-brain"></i>
            <h1>Contáctanos</h1>
        </div>
    </section>

    <!-- SECCIÓN CONTACTO -->
    <section class="contacto_contacto" data-aos="fade-right">
        <div class="contacto_contacto_container">


            <div class="contacto_form">
                <p class="subtitulo">Escríbenos</p>
                <h2>¿En qué podemos ayudarte?</h2>
                <form action="#" method="post">
                    <div class="fila">
                        <input type="text" placeholder="Nombre" required>
                        <input type="email" placeholder="Email" required>
                    </div>
                    <div class="fila">
                        <input type="text" placeholder="Teléfono">
                        <select required>
                            <option disabled selected>Tipo de consulta</option>
                            <option value="consulta">Consulta general</option>
                            <option value="cita">Cita previa</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="fila">
                        <textarea placeholder="Escribe tu consulta aquí..." rows="6" required></textarea>
                    </div>
                    <button type="submit" class="btn btn6">Enviar consulta</button>
                </form>
            </div>

            <div class="contacto_datos" data-aos="fade-left" data-aos-delay="200">
                <p class="subtitulo">Encuéntranos</p>
                <h2>Contacto</h2>
                <p><i class="fa-solid fa-location-dot"></i> Severo Ochoa X</p>
                <p><i class="fa-solid fa-phone"></i> 00000000</p>
                <p><i class="fa-solid fa-envelope"></i> info@mindcore.com</p>
                <h3>Redes Sociales</h3>
                <div class="redes_sociales">
                    <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECCIÓN CITA  -->
    <section class="contacto-cita" data-aos="fade-up">
        <div class="cita-container">
            <h2>¿Quieres pedir una cita con uno de nuestros psicólogos especializados?</h2>
            <p>Inicia sesión o regístrate para agendar tu primera sesión y empezar a mejorar tu bienestar emocional.</p>
            <div class="cita-botones">
                <button class="btn btn2" onclick="location.href='login.php'">Iniciar sesión</button>
                <button class="btn btn6" onclick="location.href='registro.php'">Registrarse</button>
            </div>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>

</body>

</html>