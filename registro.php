<?php
include("database/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $direccion = $_POST["direccion"];
    $sexo = $_POST["sexo"];
    $usuario = $_POST["usuario"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    // Insertar datos en la base de datos
    $sql = "INSERT INTO users (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo, rol) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'paciente')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo);

    if ($stmt->execute()) {
        $idUser = $conn->insert_id;
        $sql_login = "INSERT INTO users_login (idUser, usuario, password) VALUES (?, ?, ?)";
        $stmt_login = $conn->prepare($sql_login);
        $stmt_login->bind_param("iss", $idUser, $usuario, $password);

        if ($stmt_login->execute()) {
            echo "Registro exitoso. Redirigiendo al login...";
            header("refresh:2; url=login.php");
            exit();
        } else {
            echo "Error al crear credenciales.";
        }
    } else {
        echo "Error en el registro.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h2>Registro</h2>
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellidos" placeholder="Apellidos" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <input type="date" name="fecha_nacimiento" required>
        <input type="text" name="direccion" placeholder="Dirección">
        <select name="sexo">
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
            <option value="Otro">Otro</option>
        </select>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
