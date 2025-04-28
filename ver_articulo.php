<?php
include("database/conexion.php");

// Validar ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: blog.php");
  exit();
}

$idArticulo = (int) $_GET['id'];

// Obtener datos del artículo principal
$sql = "SELECT a.titulo, a.resumen, a.contenido, a.fecha, a.imagen, d.nombre, d.apellidos 
        FROM articulos a
        JOIN users_data d ON a.id_psicologo = d.idUser
        WHERE a.id = $idArticulo
        LIMIT 1";

$resultado = $conexion->query($sql);

if ($resultado->num_rows === 0) {
  header("Location: blog.php");
  exit();
}

$articulo = $resultado->fetch_assoc();

// Obtener otros artículos para la sección lateral
$sql_otros = "SELECT id, titulo FROM articulos WHERE id != $idArticulo ORDER BY fecha DESC LIMIT 5";
$otros_articulos = $conexion->query($sql_otros);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($articulo["titulo"]) ?> | MindCore</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="js/scripts.js" defer></script>
  <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="Icon" href="img/brain-solid.svg">

  <!-- Librería AOS para animaciones -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>
  <?php
  $pagina_actual = 'blog';
  include("includes/header.php");
  ?>

  <section class="portada_articulo">
    <div class="portada_articulo_container" data-aos="fade-down">
      <h1><?= htmlspecialchars($articulo["titulo"]) ?></h1>
    </div>
  </section>

  <section class="contenido_articulo_grid">
    <div class="contenido_principal" data-aos="fade-up" data-aos-delay="200">
      <?php if (!empty($articulo["resumen"])): ?>
        <div class="resumen_articulo">
          <div class="linea_vertical"></div>
          <div class="texto_resumen">
            <?= nl2br(htmlspecialchars_decode($articulo["resumen"])) ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($articulo["imagen"])): ?>
        <img src="img/articulos/<?= htmlspecialchars($articulo["imagen"]) ?>"
          alt="<?= htmlspecialchars($articulo["titulo"]) ?>">
      <?php endif; ?>


      <div class="info_autor">
        Por <?= htmlspecialchars($articulo["nombre"] . " " . $articulo["apellidos"]) ?> - <?= $articulo["fecha"] ?>
      </div>

      <div class="divider"></div>

      <div class="texto_articulo">
        <?= nl2br(htmlspecialchars_decode($articulo["contenido"])) ?>
      </div>
    </div>

    <aside class="sidebar_articulos" data-aos="fade-left" data-aos-delay="400">
      <div class="sticky_sidebar">
        <h3>Más Artículos</h3>
        <ul>
          <?php
          $delay = 0;
          while ($otro = $otros_articulos->fetch_assoc()):
            $delay += 100; // cada artículo tarda un poco más
            ?>
            <li data-aos="fade-up" data-aos-delay="<?= $delay ?>">
              <a href="ver_articulo.php?id=<?= $otro['id'] ?>">
                <?= htmlspecialchars($otro['titulo']) ?>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    </aside>
  </section>

  <?php include("includes/footer.php"); ?>

  <!-- Librería AOS para animaciones -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true
    });
  </script>

</body>

</html>