<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
include("database/conexion.php");

$errores = [];
$exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger campos
    $nombre = trim($_POST["nombre"]);
    $apellidos = trim($_POST["apellidos"]);
    $email = trim($_POST["email"]);
    $telefono = trim($_POST["telefono"]);
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $direccion = trim($_POST["direccion"]);
    $sexo = $_POST["sexo"];
    $password = $_POST["password"];

    // Validaciones
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores["email"] = "El correo electrónico no es válido.";
    }

    if (!preg_match("/^[0-9]{9}$/", $telefono)) {
        $errores["telefono"] = "El teléfono debe tener 9 dígitos numéricos.";
    }

    if (strlen($password) < 6) {
        $errores["password"] = "La contraseña debe tener al menos 6 caracteres.";
    }

    // Comprobar si el email ya existe
    $stmt = $conexion->prepare("SELECT id FROM users_login WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errores["email"] = "Este correo ya está registrado.";
    }
    $stmt->close();

    // Si no hay errores, registrar
    if (empty($errores)) {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar en users_data
        $stmt = $conexion->prepare("INSERT INTO users_data (nombre, apellidos, fecha_nacimiento, sexo, direccion, telefono) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombre, $apellidos, $fecha_nacimiento, $sexo, $direccion, $telefono);
        $stmt->execute();
        $idUser = $conexion->insert_id;

        // Insertar en users_login
        $stmt2 = $conexion->prepare("INSERT INTO users_login (email, password, tipo, idUser) VALUES (?, ?, 'user', ?)");
        $stmt2->bind_param("ssi", $email, $pass_hash, $idUser);
        $stmt2->execute();

        $exito = "✔ Registro exitoso. Ya puedes <a href='login.php'>iniciar sesión</a>.";
    }
}
?>

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

    <!-- logo en miniatura -->
    <link rel="Icon" href="img/brain-solid.svg">

    <!-- ICONSOUT CDN -->
    <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>


</head>

<?php
include('includes/header.php');
?>

<body>

<section class="registro-wrap">
  <div class="registro-formulario">
    <h2>Crea tu cuenta</h2>
    <p>Comienza tu proceso de cambio con nosotros hoy mismo</p>

    <?php if (!empty($exito)) echo "<p class='alerta-exito'>$exito</p>"; ?>

    <form method="post" novalidate>
      <input type="text" name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($nombre ?? '') ?>" required>
      
      <input type="text" name="apellidos" placeholder="Apellidos" value="<?= htmlspecialchars($apellidos ?? '') ?>" required>

      <input type="email" name="email" placeholder="Correo electrónico" value="<?= htmlspecialchars($email ?? '') ?>" required>
      <?php if (isset($errores["email"])) echo "<p class='campo-error'>{$errores["email"]}</p>"; ?>

      <input type="text" name="telefono" placeholder="Teléfono" value="<?= htmlspecialchars($telefono ?? '') ?>" required>
      <?php if (isset($errores["telefono"])) echo "<p class='campo-error'>{$errores["telefono"]}</p>"; ?>

      <input type="date" name="fecha_nacimiento" value="<?= htmlspecialchars($fecha_nacimiento ?? '') ?>" required>

      <input type="text" name="direccion" placeholder="Dirección" value="<?= htmlspecialchars($direccion ?? '') ?>">

      <select name="sexo" required>
        <option value="">Selecciona tu sexo</option>
        <option value="masculino" <?= ($sexo ?? '') == 'masculino' ? 'selected' : '' ?>>Masculino</option>
        <option value="femenino" <?= ($sexo ?? '') == 'femenino' ? 'selected' : '' ?>>Femenino</option>
        <option value="otro" <?= ($sexo ?? '') == 'otro' ? 'selected' : '' ?>>Otro</option>
      </select>

      <input type="password" name="password" placeholder="Contraseña" required>
      <?php if (isset($errores["password"])) echo "<p class='campo-error'>{$errores["password"]}</p>"; ?>

      <button class="btn3" type="submit">Registrarse</button>
    </form>

    <p class="texto-login">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
  </div>

  <div class="registro-imagen">
    <div class="registro-img-overlay">
      <h3>Tu bienestar empieza aquí</h3>
      <p>Estamos para ayudarte a encontrar el equilibrio emocional que mereces.</p>
    </div>
  </div>
</section>
    <?php include("includes/footer.php"); ?>
</body>

</html>