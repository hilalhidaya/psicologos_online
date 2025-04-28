<?php
include("includes/proteger.php");
include("database/conexion.php");

$idUser = $_SESSION["idUser"];
$tipo = $_SESSION["tipo"];
$mensaje = "";

// Procesar agendamiento de nueva cita (si paciente)
if ($_SERVER["REQUEST_METHOD"] === "POST" && $tipo === "user") {
  $idPsicologo = (int) $_POST["idPsicologo"];
  $fechaCita = $conexion->real_escape_string($_POST["fecha_cita"]);
  $motivo = $conexion->real_escape_string($_POST["motivo"]);

  $insertar = $conexion->prepare("INSERT INTO citas (idUser, id_psicologo, fecha, motivo, estado) VALUES (?, ?, ?, ?, 'pendiente')");
  $insertar->bind_param("iiss", $idUser, $idPsicologo, $fechaCita, $motivo);

  if ($insertar->execute()) {
    $mensaje = "<p class='alerta-exito'>✔ Cita agendada correctamente.</p>";
  } else {
    $mensaje = "<p class='alerta-error'>❗ Error al agendar la cita.</p>";
  }
}

// Cancelar cita (paciente)
if (isset($_GET['cancelar'])) {
  $idCancelar = (int) $_GET['cancelar'];

  $verificar = $conexion->query("SELECT * FROM citas WHERE id = $idCancelar AND idUser = $idUser AND estado IN ('pendiente', 'confirmada')");
  if ($verificar->num_rows > 0) {
    $conexion->query("UPDATE citas SET estado = 'cancelada' WHERE id = $idCancelar");
    $mensaje = "<p class='alerta-exito'>✔ Cita cancelada correctamente.</p>";
  } else {
    $mensaje = "<p class='alerta-error'>❗ No se pudo cancelar la cita.</p>";
  }
}

// Obtener lista de psicólogos (solo si es paciente)
if ($tipo === "user") {
  $sql_psico = "SELECT d.idUser, d.nombre, d.apellidos 
                  FROM users_data d 
                  JOIN users_login l ON d.idUser = l.idUser 
                  WHERE l.tipo = 'admin'";
  $psicologos = $conexion->query($sql_psico);
}

// Mostrar citas (para ambos roles)
if ($tipo === "user") {
  $sql_citas = "SELECT c.id, c.fecha, c.motivo, c.estado, d.nombre, d.apellidos
                  FROM citas c
                  JOIN users_data d ON c.id_psicologo = d.idUser
                  WHERE c.idUser = ?
                  ORDER BY c.fecha DESC";
} else {
  $sql_citas = "SELECT c.id, c.fecha, c.motivo, c.estado, d.nombre, d.apellidos
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
  $pagina_actual = 'citaciones';
  include('includes/header.php');
  ?>

  <section class="citas-wrap">
    <div class="citas-container">
      <h2>Mis citas</h2>
      <p>Consulta y gestiona tus sesiones</p>

      <?php if (!empty($mensaje))
        echo $mensaje; ?>

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
          <input type="datetime-local" name="fecha_cita" id="fecha_cita" required>

          <textarea name="motivo" placeholder="Motivo de la cita" required></textarea>
          <button class="btn btn5" type="submit">Agendar cita</button>
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
              <?php if ($tipo === "user"): ?>
                <th>Acciones</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php while ($cita = $citas->fetch_assoc()): ?>
              <tr>
                <td><?= $cita["nombre"] . " " . $cita["apellidos"] ?></td>
                <td><?= $cita["fecha"] ?></td>
                <td><?= $cita["motivo"] ?></td>
                <td><?= ucfirst($cita["estado"]) ?></td>
                <?php if ($tipo === "user"): ?>
                  <td>
                    <?php if (in_array($cita["estado"], ["pendiente", "confirmada"])): ?>
                      <a href="citaciones.php?cancelar=<?= $cita["id"] ?>" class="btn_cancelar"
                        onclick="return confirm('¿Seguro que deseas cancelar esta cita?')">Cancelar</a>
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <?php include("includes/footer.php"); ?>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const fechaInput = document.getElementById('fecha_cita');
      if (!fechaInput) return;

      // Establecer mínimo (hoy +1 minuto) y máximo (hoy +1 mes)
      const now = new Date();
      now.setMinutes(now.getMinutes() + 1);

      const max = new Date();
      max.setMonth(max.getMonth() + 1); // un mes después

      fechaInput.min = now.toISOString().slice(0, 16);
      fechaInput.max = max.toISOString().slice(0, 16);

      // Validar cada vez que el usuario cambia fecha/hora
      fechaInput.addEventListener('input', function () {
        const selected = new Date(this.value);

        const day = selected.getDay(); // 0 = Domingo, 6 = Sábado
        const hour = selected.getHours();

        // Bloquear fines de semana
        if (day === 0 || day === 6) {
          alert('No se pueden agendar citas los fines de semana.');
          this.value = '';
          return;
        }

        // Bloquear fuera de horario laboral
        if (hour < 10 || hour >= 19) {
          alert('El horario permitido es de 10:00 a 19:00.');
          this.value = '';
          return;
        }
      });
    });
  </script>

</body>

</html>