<?php
include("includes/proteger.php");
include("database/conexion.php");

// Solo permitir administradores
if (!isset($_SESSION["idUser"]) || $_SESSION["tipo"] !== "admin") {
    header("Location: index.php");
    exit();
}

// CREAR ARTÍCULO
if (isset($_POST['crear_articulo'])) {
    $idPsicologo = (int) $_SESSION["idUser"];
    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $resumen = $conexion->real_escape_string($_POST['resumen']);
    $contenido = $conexion->real_escape_string($_POST['contenido']);
    $fecha = date('Y-m-d H:i:s');

    // Manejar imagen
    $nombreImagen = "";
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $carpeta = "img/articulos/";
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $nombreUnico = uniqid() . "_" . basename($_FILES['imagen']['name']);
        $rutaDestino = $carpeta . $nombreUnico;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
        $nombreImagen = $nombreUnico;
    }

    $conexion->query("INSERT INTO articulos (titulo, resumen, contenido, fecha, id_psicologo, imagen) 
                      VALUES ('$titulo', '$resumen', '$contenido', '$fecha', $idPsicologo, '$nombreImagen')");

    header("Location: articulos_admin.php");
    exit();
}

// EDITAR ARTÍCULO
if (isset($_POST['editar_articulo'])) {
    $id = (int) $_POST['id'];
    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $resumen = $conexion->real_escape_string($_POST['resumen']);
    $contenido = $conexion->real_escape_string($_POST['contenido']);

    $nombreImagen = "";

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $carpeta = "img/articulos/";
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $nombreUnico = uniqid() . "_" . basename($_FILES['imagen']['name']);
        $rutaDestino = $carpeta . $nombreUnico;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
        $nombreImagen = ", imagen='$nombreUnico'";
    }

    $conexion->query("UPDATE articulos SET titulo='$titulo', resumen='$resumen', contenido='$contenido' $nombreImagen WHERE id=$id");

    header("Location: articulos_admin.php");
    exit();
}

// ELIMINAR ARTÍCULO
if (isset($_GET['eliminar'])) {
    $id = (int) $_GET['eliminar'];
    $conexion->query("DELETE FROM articulos WHERE id=$id");

    header("Location: articulos_admin.php");
    exit();
}

// OBTENER ARTÍCULOS
$sql = "SELECT a.id, a.titulo, a.fecha, d.nombre, d.apellidos 
        FROM articulos a
        JOIN users_data d ON a.id_psicologo = d.idUser
        ORDER BY a.fecha DESC";
$resultado = $conexion->query($sql);

// SI SE ESTÁ EDITANDO
$editando = false;
if (isset($_GET['editar'])) {
    $editando = true;
    $idEditar = (int) $_GET['editar'];

    $consulta = $conexion->query("SELECT titulo, resumen, contenido FROM articulos WHERE id=$idEditar");
    $articuloEditar = $consulta->fetch_assoc();
}
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="Icon" href="img/brain-solid.svg">
</head>

<body>
    <?php
    $pagina_actual = 'articulos_admin';
    include("includes/header.php");
    ?>

    <section class="admin-wrap">
        <div class="admin-container">
            <h2>Administrar Artículos</h2>

            <?php if (!$editando): ?>
                <button onclick="toggleCrearArticulo()" class="btn6">Crear Nuevo Artículo</button>

                <div id="formCrearArticulo" style="display:none; margin-top:20px; opacity:0; transition: opacity 0.5s;">
                    <div class="form-crear">
                        <form action="articulos_admin.php" method="POST" enctype="multipart/form-data" class="form-grid">
                            <div style="grid-column: span 2;">
                                <label>Título:</label>
                                <input type="text" name="titulo" required>
                            </div>
                            <div style="grid-column: span 2;">
                                <label>Resumen:</label>
                                <textarea name="resumen" rows="3" required></textarea>
                            </div>
                            <div style="grid-column: span 2;">
                                <label>Contenido:</label>
                                <textarea name="contenido" id="editor" rows="6" required></textarea>
                            </div>
                            <div style="grid-column: span 2;">
                                <label>Imagen:</label>
                                <input type="file" name="imagen" accept="image/*">
                            </div>
                            <div style="grid-column: span 2; text-align:center;">
                                <button type="submit" name="crear_articulo" class="btn2">Publicar Artículo</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($editando): ?>
                <div class="form-editar">
                    <h3>Editar Artículo</h3>
                    <form action="articulos_admin.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $idEditar ?>">

                        <label>Título:</label>
                        <input type="text" name="titulo" value="<?= htmlspecialchars($articuloEditar['titulo']) ?>"
                            required>

                        <label>Resumen:</label>
                        <textarea name="resumen" rows="3"
                            required><?= htmlspecialchars($articuloEditar['resumen']) ?></textarea>

                        <label>Contenido:</label>
                        <textarea name="contenido" id="editor" rows="6"
                            required><?= htmlspecialchars($articuloEditar['contenido']) ?></textarea>

                        <label>Cambiar Imagen:</label>
                        <input type="file" name="imagen" accept="image/*">

                        <button type="submit" name="editar_articulo" class="btn2">Guardar Cambios</button>
                        <a href="articulos_admin.php" class="btn-danger">Cancelar</a>
                    </form>
                </div>
            <?php endif; ?>

            <div class="tabla-admin">
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["titulo"]) ?></td>
                                <td><?= htmlspecialchars($row["nombre"] . " " . $row["apellidos"]) ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($row["fecha"]))) ?></td>
                                <td style="position: relative;">
                                    <button class="btn-acciones" onclick="toggleMenu(this)">⋮</button>
                                    <div class="menu-acciones">
                                        <a href="articulos_admin.php?editar=<?= $row["id"] ?>">Editar</a>
                                        <a href="articulos_admin.php?eliminar=<?= $row["id"] ?>"
                                            onclick="return confirm('¿Seguro que deseas eliminar este artículo?')">Eliminar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

    <?php include("includes/footer.php"); ?>

    <!-- Toggle Crear Artículo -->
    <script>
        function toggleCrearArticulo() {
            var form = document.getElementById('formCrearArticulo');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
                setTimeout(function () {
                    form.style.opacity = '1';
                }, 10);
            } else {
                form.style.opacity = '0';
                setTimeout(function () {
                    form.style.display = 'none';
                }, 500);
            }
        }
    </script>



    <script>
        function toggleMenu(button) {
            const menu = button.nextElementSibling;
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';

            // Cierra otros menús abiertos
            document.querySelectorAll('.menu-acciones').forEach(function (otherMenu) {
                if (otherMenu !== menu) {
                    otherMenu.style.display = 'none';
                }
            });
        }

        // Cierra el menú si haces click fuera
        document.addEventListener('click', function (e) {
            if (!e.target.matches('.btn-acciones')) {
                document.querySelectorAll('.menu-acciones').forEach(function (menu) {
                    menu.style.display = 'none';
                });
            }
        });
    </script>


</body>

</html>