<?php
session_start();
include("database/conexion.php");

if (!isset($_SESSION["idUser"])) {
    header("Location: login.php");
    exit();
}

$idUser = $_SESSION["idUser"];
$rol = $_SESSION["rol"];

// Obtener la lista de psicólogos para que el paciente pueda elegir
$sql_psicologos = "SELECT idUser, nombre, apellidos FROM users WHERE rol='psicologo'";
$result_psicologos = $conn->query($sql_psicologos);

// Si el usuario es paciente, mostrar formulario para agendar cita
if ($rol == "paciente" && $_SERVER["REQUEST_METHOD"] == "POST") {
    $idPsicologo = $_POST["idPsicologo"];
    $fecha_cita = $_POST["fecha_cita"];
    $motivo = $_POST["motivo"];

    $sql_cita = "INSERT INTO citas (idPaciente, idPsicologo, fecha_cita, motivo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_cita);
    $stmt->bind_param("iiss", $idUser, $idPsicologo, $fecha_cita, $motivo);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Cita agendada correctamente.</p>";
    } else {
        echo "<p style='color:red;'>Error al agendar la cita.</p>";
    }
}

// Mostrar citas programadas
if ($rol == "psicologo") {
    $sql_citas = "SELECT c.idCita, u.nombre, u.apellidos, c.fecha_cita, c.motivo, c.estado 
                  FROM citas c
                  JOIN users u ON c.idPaciente = u.idUser
                  WHERE c.idPsicologo = ?";
} else {
    $sql_citas = "SELECT c.idCita, u.nombre, u.apellidos, c.fecha_cita, c.motivo, c.estado 
                  FROM citas c
                  JOIN users u ON c.idPsicologo = u.idUser
                  WHERE c.idPaciente = ?";
}

$stmt = $conn->prepare($sql_citas);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result_citas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Citas</title>
</head>
<body>
    <h2>Gestión de Citas</h2>

    <?php if ($rol == "paciente") { ?>
        <h3>Agendar una nueva cita</h3>
        <form method="post">
            <label for="idPsicologo">Selecciona un Psicólogo:</label>
            <select name="idPsicologo" required>
                <?php while ($row = $result_psicologos->fetch_assoc()) { ?>
                    <option value="<?php echo $row["idUser"]; ?>">
                        <?php echo $row["nombre"] . " " . $row["apellidos"]; ?>
                    </option>
                <?php } ?>
            </select>
            <input type="datetime-local" name="fecha_cita" required>
            <textarea name="motivo" placeholder="Motivo de la cita" required></textarea>
            <button type="submit">Agendar Cita</button>
        </form>
    <?php } ?>

    <h3>Tus citas programadas</h3>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Motivo</th>
            <th>Estado</th>
        </tr>
        <?php while ($row = $result_citas->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["nombre"] . " " . $row["apellidos"]; ?></td>
                <td><?php echo $row["fecha_cita"]; ?></td>
                <td><?php echo $row["motivo"]; ?></td>
                <td><?php echo $row["estado"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
