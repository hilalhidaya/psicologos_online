<?php
include("includes/proteger.php");
include("database/conexion.php");

$idUser = $_SESSION["idUser"];
$mensaje = "";

// Consulta
$sql = "SELECT d.nombre, d.apellidos, d.fecha_nacimiento, d.sexo, d.direccion, d.telefono, l.email, l.password
        FROM users_data d 
        JOIN users_login l ON d.idUser = l.idUser 
        WHERE d.idUser = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

// ✅ Validar si encontró usuario
if (!$usuario) {
    echo "<p style='color:red;'>❗ No se encontró información del usuario. Intenta registrarte de nuevo.</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $apellidos = trim($_POST["apellidos"]);
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $sexo = $_POST["sexo"];
    $direccion = trim($_POST["direccion"]);
    $telefono = trim($_POST["telefono"]);

    $contrasena_actual = $_POST["contrasena_actual"] ?? '';
    $nueva_contrasena = $_POST["nueva_contrasena"] ?? '';
    $repetir_contrasena = $_POST["repetir_contrasena"] ?? '';

    // Actualizar datos personales
    $sql1 = "UPDATE users_data SET nombre=?, apellidos=?, fecha_nacimiento=?, sexo=?, direccion=?, telefono=? WHERE idUser=?";
    $stmt1 = $conexion->prepare($sql1);
    $stmt1->bind_param("ssssssi", $nombre, $apellidos, $fecha_nacimiento, $sexo, $direccion, $telefono, $idUser);
    $stmt1->execute();

    // Cambiar contraseña si corresponde
    if (!empty($contrasena_actual) && !empty($nueva_contrasena) && !empty($repetir_contrasena)) {
        if (password_verify($contrasena_actual, $usuario["password"])) {
            if ($nueva_contrasena === $repetir_contrasena) {
                $nueva_password_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
                $sql3 = "UPDATE users_login SET password=? WHERE idUser=?";
                $stmt3 = $conexion->prepare($sql3);
                $stmt3->bind_param("si", $nueva_password_hash, $idUser);
                $stmt3->execute();
                $mensaje = "<p class='alerta-exito'>✔ Datos y contraseña actualizados correctamente.</p>";
            } else {
                $mensaje = "<p class='alerta-error'>❗ Las nuevas contraseñas no coinciden.</p>";
            }
        } else {
            $mensaje = "<p class='alerta-error'>❗ Contraseña actual incorrecta.</p>";
        }
    } else {
        $mensaje = "<p class='alerta-exito'>✔ Datos actualizados correctamente.</p>";
    }

    // REFRESCAR datos tras actualizar
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idUser);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
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

    <!-- se utiliza para asegurar que las páginas web se rendericen correctamente en las versiones más recientes del navegador -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- logo en miniatura -->
    <link rel="Icon" href="img/brain-solid.svg">

    <!-- ICONSOUT CDN -->
    <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>

</head>

<body>

    <?php include("includes/header.php"); ?>

    <section class="perfil-wrap">
        <div class="perfil-container">
            <h2>Mi Perfil</h2>
            <p>Consulta y edita tu información personal</p>

            <?php if (!empty($mensaje))
                echo $mensaje; ?>

            <form method="POST" id="formulario-perfil">
                <label>Correo electrónico (no editable)</label>
                <input type="email" value="<?= htmlspecialchars($usuario['email']) ?>" disabled>

                <label>Nombre</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required disabled>

                <label>Apellidos</label>
                <input type="text" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos']) ?>" required
                    disabled>

                <label>Teléfono</label>
                <input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" required
                    disabled>

                <label>Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" value="<?= htmlspecialchars($usuario['fecha_nacimiento']) ?>"
                    required disabled>

                <label>Dirección</label>
                <input type="text" name="direccion" value="<?= htmlspecialchars($usuario['direccion']) ?>" disabled>

                <label>Sexo</label>
                <select name="sexo" disabled>
                    <option value="">Seleccionar</option>
                    <option value="masculino" <?= ($usuario['sexo'] == 'masculino') ? 'selected' : '' ?>>Masculino</option>
                    <option value="femenino" <?= ($usuario['sexo'] == 'femenino') ? 'selected' : '' ?>>Femenino</option>
                    <option value="otro" <?= ($usuario['sexo'] == 'otro') ? 'selected' : '' ?>>Otro</option>
                </select>

                <h3>Cambiar Contraseña</h3>

                <label>Contraseña actual</label>
                <input type="password" name="contrasena_actual" placeholder="********" disabled>

                <label>Nueva contraseña</label>
                <input type="password" name="nueva_contrasena" placeholder="********" disabled>

                <label>Repetir nueva contraseña</label>
                <input type="password" name="repetir_contrasena" placeholder="********" disabled>

                <div class="perfil-botones">
                    <button type="button" id="btn-editar" class="btn2">Editar</button>
                    <button type="submit" id="btn-guardar" class="btn3" style="display:none;">Guardar cambios</button>
                </div>
            </form>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>

    <script src="js/citaciones.js"></script>

</body>

</html>