<?php
session_start();
include("database/conexion.php");

if (!isset($_SESSION["idUser"])) {
    header("Location: login.php");
    exit();
}

$idUser = $_SESSION["idUser"];

// Obtener la información actual del usuario
$sql = "SELECT nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo FROM users WHERE idUser = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Procesar la actualización del perfil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $direccion = $_POST["direccion"];
    $sexo = $_POST["sexo"];

    $update_sql = "UPDATE users SET nombre=?, apellidos=?, email=?, telefono=?, fecha_nacimiento=?, direccion=?, sexo=? WHERE idUser=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssssi", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $idUser);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Perfil actualizado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>Error al actualizar el perfil.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
</head>
<body>
    <h2>Perfil de Usuario</h2>
    <form method="post">
        <input type="text" name="nombre" value="<?php echo $user['nombre']; ?>" required>
        <input type="text" name="apellidos" value="<?php echo $user['apellidos']; ?>" required>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        <input type="text" name="telefono" value="<?php echo $user['telefono']; ?>" required>
        <input type="date" name="fecha_nacimiento" value="<?php echo $user['fecha_nacimiento']; ?>" required>
        <input type="text" name="direccion" value="<?php echo $user['direccion']; ?>">
        <select name="sexo">
            <option value="M" <?php if ($user['sexo'] == 'M') echo 'selected'; ?>>Masculino</option>
            <option value="F" <?php if ($user['sexo'] == 'F') echo 'selected'; ?>>Femenino</option>
            <option value="Otro" <?php if ($user['sexo'] == 'Otro') echo 'selected'; ?>>Otro</option>
        </select>
        <button type="submit">Actualizar Perfil</button>
    </form>
</body>
</html>