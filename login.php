<?php
session_start();
include("database/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Verificar si el usuario existe en la base de datos
    $sql = "SELECT users_login.idUser, users_login.usuario, users_login.password, users.rol 
            FROM users_login 
            INNER JOIN users ON users_login.idUser = users.idUser
            WHERE usuario = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($password, $row["password"])) {
            $_SESSION["idUser"] = $row["idUser"];
            $_SESSION["usuario"] = $row["usuario"];
            $_SESSION["rol"] = $row["rol"];

            if ($row["rol"] == "psicologo") {
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form method="post">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>

    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
</body>
</html>