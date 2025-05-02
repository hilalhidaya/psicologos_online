<?php
include("includes/proteger.php");
include("database/conexion.php");

// Solo permitir administradores
if (!isset($_SESSION["idUser"]) || $_SESSION["tipo"] !== "admin") {
    header("Location: index.php");
    exit();
}

// CREAR USUARIO
if (isset($_POST['crear_usuario'])) {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $apellidos = $conexion->real_escape_string($_POST['apellidos']);
    $email = $conexion->real_escape_string($_POST['email']);
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conexion->query("INSERT INTO users_data (nombre, apellidos) VALUES ('$nombre', '$apellidos')");
    $idUser = $conexion->insert_id;
    $conexion->query("INSERT INTO users_login (idUser, email, password, tipo) VALUES ($idUser, '$email', '$password', '$tipo')");

    header("Location: usuarios_admin.php");
    exit();
}


// EDITAR USUARIO
if (isset($_POST['editar_usuario'])) {
    $idUser = (int) $_POST['idUser'];
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $apellidos = $conexion->real_escape_string($_POST['apellidos']);
    $email = $conexion->real_escape_string($_POST['email']);
    $tipo = $conexion->real_escape_string($_POST['tipo']);

    $conexion->query("UPDATE users_data SET nombre='$nombre', apellidos='$apellidos' WHERE idUser=$idUser");
    $conexion->query("UPDATE users_login SET email='$email', tipo='$tipo' WHERE idUser=$idUser");

    header("Location: usuarios_admin.php");
    exit();
}

// ELIMINAR USUARIO
if (isset($_GET['eliminar'])) {
    $idUser = (int) $_GET['eliminar'];

    $conexion->query("DELETE FROM users_login WHERE idUser = $idUser");
    $conexion->query("DELETE FROM users_data WHERE idUser = $idUser");

    header("Location: usuarios_admin.php");
    exit();
}

// OBTENER USUARIOS
$sql = "SELECT d.idUser, d.nombre, d.apellidos, d.fecha_nacimiento, d.sexo, d.direccion, d.telefono, l.email, l.tipo 
        FROM users_data d 
        JOIN users_login l ON d.idUser = l.idUser 
        ORDER BY d.nombre ASC";
$resultado = $conexion->query($sql);

// SI SE ESTÁ EDITANDO
$editando = false;
if (isset($_GET['editar'])) {
    $editando = true;
    $idEditar = (int) $_GET['editar'];

    $consulta = $conexion->query("SELECT d.nombre, d.apellidos, l.email, l.tipo FROM users_data d JOIN users_login l ON d.idUser = l.idUser WHERE d.idUser = $idEditar");
    $usuarioEditar = $consulta->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MindCore - Administrar Usuarios</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="js/scripts.js" defer></script>
    <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="Icon" href="img/brain-solid.svg">
    <script>
        function toggleCrearUsuario() {
            var form = document.getElementById('formCrearUsuario');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</head>

<body>
    <?php
    $pagina_actual = 'usuarios_admin';
    include("includes/header.php");
    ?>

    <section class="admin-wrap">
        <div class="admin-container">
            <h2>Administrar Usuarios</h2>

            <?php if (!$editando): ?>
                <button onclick="toggleCrearUsuario()" class="btn6">Crear Nuevo Usuario</button>

                <div id="formCrearUsuario" style="display:none; margin-top:20px;">
                    <div class="form-crear">
                        <form action="usuarios_admin.php" method="POST" class="form-grid">
                            <div>
                                <label>Nombre:</label>
                                <input type="text" name="nombre" required>
                            </div>
                            <div>
                                <label>Apellidos:</label>
                                <input type="text" name="apellidos" required>
                            </div>
                            <div>
                                <label>Email:</label>
                                <input type="email" name="email" required>
                            </div>
                            <div>
                                <label>Contraseña:</label>
                                <input type="password" name="password" required>
                            </div>
                            <div>
                                <label>Rol:</label>
                                <select name="tipo" required>
                                    <option value="user">Usuario</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                            <div style="grid-column: span 2; text-align:center;">
                                <button type="submit" name="crear_usuario" class="btn2">Crear Usuario</button>
                            </div>
                        </form>
                    </div>

                </div>
            <?php endif; ?>

            <?php if ($editando): ?>
                <div class="form-editar">
                    <h3>Editar Usuario</h3>
                    <form action="usuarios_admin.php" method="POST">
                        <input type="hidden" name="idUser" value="<?= $idEditar ?>">

                        <label>Nombre:</label>
                        <input type="text" name="nombre" value="<?= htmlspecialchars($usuarioEditar['nombre']) ?>" required>

                        <label>Apellidos:</label>
                        <input type="text" name="apellidos" value="<?= htmlspecialchars($usuarioEditar['apellidos']) ?>"
                            required>

                        <label>Email:</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($usuarioEditar['email']) ?>" required>

                        <label>Rol:</label>
                        <select name="tipo" required>
                            <option value="user" <?= $usuarioEditar['tipo'] == 'user' ? 'selected' : '' ?>>Usuario</option>
                            <option value="admin" <?= $usuarioEditar['tipo'] == 'admin' ? 'selected' : '' ?>>Administrador
                            </option>
                        </select>

                        <button type="submit" name="editar_usuario" class="btn2">Guardar Cambios</button>
                        <a href="usuarios_admin.php" class="btn-danger">Cancelar</a>
                    </form>
                </div>
            <?php endif; ?>

            <div class="tabla-admin">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["nombre"] . " " . $row["apellidos"]) ?></td>
                                <td><?= htmlspecialchars($row["email"]) ?></td>
                                <td><?= htmlspecialchars($row["tipo"] === "admin" ? "Administrador" : "Usuario") ?></td>
                                <td style="position: relative;">
                                    <button class="btn-acciones" onclick="toggleMenu(this)">⋮</button>
                                    <div class="menu-acciones">
                                        <a href="usuarios_admin.php?editar=<?= $row["idUser"] ?>">Editar</a>
                                        <a href="usuarios_admin.php?eliminar=<?= $row["idUser"] ?>"
                                            onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
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

    <script>
        function toggleMenu(button) {
            const menu = button.nextElementSibling;
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';

            // Cierra otros menús si abres uno nuevo
            document.querySelectorAll('.menu-acciones').forEach(function (otherMenu) {
                if (otherMenu !== menu) {
                    otherMenu.style.display = 'none';
                }
            });
        }

        // Cierra los menús si haces click fuera
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