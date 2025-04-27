<?php
include("includes/proteger.php");
include("database/conexion.php");

// Solo permitir administradores
if (!isset($_SESSION["idUser"]) || $_SESSION["tipo"] !== "admin") {
    header("Location: index.php");
    exit();
}

// Obtener todos los usuarios
$sql = "SELECT d.idUser, d.nombre, d.apellidos, d.fecha_nacimiento, d.sexo, d.direccion, d.telefono, l.email, l.tipo 
        FROM users_data d 
        JOIN users_login l ON d.idUser = l.idUser 
        ORDER BY d.nombre ASC";
$resultado = $conexion->query($sql);

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
<?php
$pagina_actual = 'usuarios_admin';
include("includes/header.php");
?>

<section class="admin-wrap">
  <div class="admin-container">
    <h2>Administrar Usuarios</h2>
    <a href="crear_usuario.php" class="btn3">Crear Nuevo Usuario</a>

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
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row["nombre"] . " " . $row["apellidos"]) ?></td>
              <td><?= htmlspecialchars($row["email"]) ?></td>
              <td><?= htmlspecialchars($row["tipo"] === "admin" ? "Administrador" : "Usuario") ?></td>
              <td>
                <a href="editar_usuario.php?id=<?= $row["idUser"] ?>" class="btn2">Editar</a>
                <a href="eliminar_usuario.php?id=<?= $row["idUser"] ?>" class="btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

  </div>
</section>

<?php include("includes/footer.php"); ?>
</body>
</html>
