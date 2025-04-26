<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
include("database/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Buscar usuario
    $stmt = $conexion->prepare("SELECT idUser, password, tipo FROM users_login WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($idUser, $hash, $tipo);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            $_SESSION["idUser"] = $idUser;
            $_SESSION["tipo"] = $tipo;
            $mensaje = "<p class='alerta-exito'>✔ Bienvenido de nuevo. Redirigiendo al inicio...</p>";
            header("refresh:2; url=index.php");
            exit();
        } else {
            $mensaje = "<p class='alerta-error'>❗ Contraseña incorrecta.</p>";
        }
    } else {
        $mensaje = "<p class='alerta-error'>❗ No existe una cuenta con ese correo.</p>";
    }

    $stmt->close();
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
<?php
include('includes/header.php');
?>

<body>


<section class="login-wrap">
  <div class="login-fondo"></div>
  <div class="login-card">
    <h2>Bienvenido de nuevo</h2>
    <p>Introduce tus datos para iniciar sesión</p>

    <?php if (!empty($mensaje)) echo $mensaje; ?>

    <form method="POST">
      <label for="email">Correo electrónico</label>
      <input type="email" name="email" required placeholder="ejemplo@correo.com">

      <label for="password">Contraseña</label>
      <input type="password" name="password" required placeholder="********">

      <button class="btn3" type="submit">Iniciar sesión</button>
    </form>

    <p class="texto-registro">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
  </div>
</section>

<?php include("includes/footer.php"); ?>
</body>

</html>