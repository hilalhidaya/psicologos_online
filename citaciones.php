<?php
include("includes/proteger.php");
include("database/conexion.php");

$idUser = $_SESSION["idUser"];
$tipo = $_SESSION["tipo"];
$mensaje = "";

// Obtener lista de psicólogos (solo si es paciente)
if ($tipo === "user") {
    $sql_psico = "SELECT d.idUser, d.nombre, d.apellidos 
                  FROM users_data d 
                  JOIN users_login l ON d.idUser = l.idUser 
                  WHERE l.tipo = 'admin'";
    $psicologos = $conexion->query($sql_psico);
}

// Procesar agendamiento de cita
if ($_SERVER["REQUEST_METHOD"] === "POST" && $tipo === "user") {
    $idPsicologo = $_POST["idPsicologo"];
    $fecha = $_POST["fecha_cita"];
    $motivo = $_POST["motivo"];

    $sql_insert = "INSERT INTO citas (idUser, id_psicologo, fecha, motivo, estado) VALUES (?, ?, ?, ?, 'pendiente')";
    $stmt = $conexion->prepare($sql_insert);
    $stmt->bind_param("iiss", $idUser, $idPsicologo, $fecha, $motivo);
    if ($stmt->execute()) {
        $mensaje = "<p class='alerta-exito'>✔ Cita agendada correctamente.</p>";
    } else {
        $mensaje = "<p class='alerta-error'>❗ Error al agendar la cita.</p>";
    }
}

// Mostrar citas (para ambos roles)
if ($tipo === "user") {
    $sql_citas = "SELECT c.fecha, c.motivo, c.estado, d.nombre, d.apellidos
                  FROM citas c
                  JOIN users_data d ON c.id_psicologo = d.idUser
                  WHERE c.idUser = ?
                  ORDER BY c.fecha DESC";
} else {
    $sql_citas = "SELECT c.fecha, c.motivo, c.estado, d.nombre, d.apellidos
                  FROM citas c
                  JOIN users_data d ON c.idUser = d.idUser
                  WHERE c.id_psicologo = ?
                  ORDER BY c.fecha DESC";
}
$stmt = $conexion->prepare($sql_citas);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$citas = $stmt->get_result();
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="Icon" href="img/brain-solid.svg">
</head>

<body>

<?php
$pagina_actual = 'contacto';
include('includes/header.php');
?>

<section class="citas-wrap">
    <div class="citas-container">
        <h2>Mis citas</h2>
        <p>Consulta y gestiona tus sesiones</p>

        <?php if (!empty($mensaje)) echo $mensaje; ?>

        <?php if ($tipo === "user"): ?>
            <form method="POST" class="citas-formulario">
                <h3>Agendar nueva cita</h3>
                <select name="idPsicologo" required>
                    <option value="">Selecciona un profesional</option>
                    <?php while ($p = $psicologos->fetch_assoc()): ?>
                        <option value="<?= $p['idUser'] ?>">
                            <?= $p['nombre'] . " " . $p['apellidos'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <input type="datetime-local" name="fecha_cita" required>
                <textarea name="motivo" placeholder="Motivo de la cita" required></textarea>
                <button class="btn3" type="submit">Agendar cita</button>
            </form>
        <?php endif; ?>

        <div class="citas-listado">
            <h3><?= $tipo === "user" ? "Citas con tus psicólogos" : "Citas asignadas a ti" ?></h3>
            <table>
                <thead>
                    <tr>
                        <th><?= $tipo === "user" ? "Psicólogo" : "Paciente" ?></th>
                        <th>Fecha</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cita = $citas->fetch_assoc()): ?>
                        <tr>
                            <td><?= $cita["nombre"] . " " . $cita["apellidos"] ?></td>
                            <td><?= $cita["fecha"] ?></td>
                            <td><?= $cita["motivo"] ?></td>
                            <td><?= ucfirst($cita["estado"]) ?></td>
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
