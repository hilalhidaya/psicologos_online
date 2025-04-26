
<?php
include("includes/proteger.php");
include("database/conexion.php");

$idUser = $_SESSION["idUser"];
$mensaje = "";

// Obtener datos del usuario
$sql = "SELECT d.nombre, d.apellidos, d.fecha_nacimiento, d.sexo, d.direccion, d.telefono, l.email 
        FROM users_data d 
        JOIN users_login l ON d.idUser = l.idUser 
        WHERE d.idUser = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $apellidos = trim($_POST["apellidos"]);
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $sexo = $_POST["sexo"];
    $direccion = trim($_POST["direccion"]);
    $telefono = trim($_POST["telefono"]);
    $email = trim($_POST["email"]);

    // Actualizar datos personales
    $sql1 = "UPDATE users_data SET nombre=?, apellidos=?, fecha_nacimiento=?, sexo=?, direccion=?, telefono=? WHERE idUser=?";
    $stmt1 = $conexion->prepare($sql1);
    $stmt1->bind_param("ssssssi", $nombre, $apellidos, $fecha_nacimiento, $sexo, $direccion, $telefono, $idUser);
    $stmt1->execute();

    // Actualizar email
    $sql2 = "UPDATE users_login SET email=? WHERE idUser=?";
    $stmt2 = $conexion->prepare($sql2);
    $stmt2->bind_param("si", $email, $idUser);
    $stmt2->execute();

    $mensaje = "<p class='alerta-exito'>✔ Datos actualizados correctamente.</p>";
    $usuario = compact("nombre", "apellidos", "fecha_nacimiento", "sexo", "direccion", "telefono", "email");
}
?>



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
    <link rel="stylesheet" href="css/perfil.css">

    <section class="perfil-wrap">
        <div class="perfil-container">
            <h2>Mi Perfil</h2>
            <p>Consulta y edita tu información personal</p>

            <?php if (!empty($mensaje))
                echo $mensaje; ?>

            <form method="post">
                <input type="text" name="nombre" placeholder="Nombre" value="<?= $usuario['nombre'] ?>" required>
                <input type="text" name="apellidos" placeholder="Apellidos" value="<?= $usuario['apellidos'] ?>"
                    required>
                <input type="email" name="email" placeholder="Correo electrónico" value="<?= $usuario['email'] ?>"
                    required>
                <input type="text" name="telefono" placeholder="Teléfono" value="<?= $usuario['telefono'] ?>" required>
                <input type="date" name="fecha_nacimiento" value="<?= $usuario['fecha_nacimiento'] ?>" required>
                <input type="text" name="direccion" placeholder="Dirección" value="<?= $usuario['direccion'] ?>">
                <select name="sexo" required>
                    <option value="">Sexo</option>
                    <option value="masculino" <?= ($usuario['sexo'] == 'masculino') ? 'selected' : '' ?>>Masculino</option>
                    <option value="femenino" <?= ($usuario['sexo'] == 'femenino') ? 'selected' : '' ?>>Femenino</option>
                    <option value="otro" <?= ($usuario['sexo'] == 'otro') ? 'selected' : '' ?>>Otro</option>
                </select>
                <button class="btn3" type="submit">Guardar cambios</button>
            </form>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>

</body>

</html>