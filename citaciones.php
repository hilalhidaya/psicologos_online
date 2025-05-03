<?php
include("includes/proteger.php");
include("database/conexion.php");

$idUser = $_SESSION["idUser"];
$tipo = $_SESSION["tipo"];
$mensaje = "";

// Procesar agendamiento de nueva cita
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion"]) && $_POST["accion"] === "crear") {
  $idPsicologo = (int) $_POST["idPsicologo"];
  $fecha = $conexion->real_escape_string($_POST["fecha"]);
  $hora = $conexion->real_escape_string($_POST["hora"]);
  $motivo = $conexion->real_escape_string($_POST["motivo"]);

  $insertar = $conexion->prepare("INSERT INTO citas (idUser, id_psicologo, fecha, hora, motivo, estado) VALUES (?, ?, ?, ?, ?, 'pendiente')");
  $insertar->bind_param("iisss", $idUser, $idPsicologo, $fecha, $hora, $motivo);

  if ($insertar->execute()) {
    $mensaje = "<p class='alerta-exito'>✔ Cita agendada correctamente.</p>";
  } else {
    $mensaje = "<p class='alerta-error'>❗ Error al agendar la cita.</p>";
  }
}

// Cancelar cita
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

// Editar cita
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion"]) && $_POST["accion"] === "editar") {
  $idCita = (int) $_POST["idCita"];
  $fecha = $conexion->real_escape_string($_POST["fecha"]);
  $hora = $conexion->real_escape_string($_POST["hora"]);
  $motivo = $conexion->real_escape_string($_POST["motivo"]);

  $conexion->query("UPDATE citas SET fecha = '$fecha', hora = '$hora', motivo = '$motivo' WHERE id = $idCita AND idUser = $idUser");
  $mensaje = "<p class='alerta-exito'>✔ Cita modificada correctamente.</p>";
}

// Obtener lista de psicólogos
if ($tipo === "user") {
  $sql_psico = "SELECT d.idUser, d.nombre, d.apellidos 
                FROM users_data d 
                JOIN users_login l ON d.idUser = l.idUser 
                WHERE l.tipo = 'admin'";
  $psicologos = $conexion->query($sql_psico);
}

// Mostrar citas
$sql_citas = "SELECT c.id, c.fecha, c.hora, c.motivo, c.estado, d.nombre, d.apellidos
              FROM citas c
              JOIN users_data d ON c.id_psicologo = d.idUser
              WHERE c.idUser = ?
              ORDER BY c.fecha DESC";
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
      <?= $mensaje ?>

      <!-- Formulario nueva cita -->
      <?php if ($tipo === "user"): ?>
        <form method="POST" class="citas-formulario">
          <h3>Agendar nueva cita</h3>
          <input type="hidden" name="accion" value="crear">
          <select name="idPsicologo" required>
            <option value="">Selecciona un profesional</option>
            <?php while ($p = $psicologos->fetch_assoc()): ?>
              <option value="<?= $p['idUser'] ?>"><?= $p['nombre'] . " " . $p['apellidos'] ?></option>
            <?php endwhile; ?>
          </select>
          <div class="fecha-hora">
            <input type="date" name="fecha" id="fecha" required>
            <input type="time" name="hora" id="hora" required>
          </div>
          <textarea name="motivo" placeholder="Motivo de la cita" required></textarea>
          <button class="btn btn5" type="submit">Agendar cita</button>
        </form>
      <?php endif; ?>

      <!-- Listado de citas -->
      <div class="citas-listado">
        <h3>Citas con tus psicólogos</h3>
        <table>
          <thead>
            <tr>
              <th>Psicólogo</th>
              <th>Fecha</th>
              <th>Motivo</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($cita = $citas->fetch_assoc()): ?>
              <tr>
                <td><?= $cita["nombre"] . " " . $cita["apellidos"] ?></td>
                <td><?= $cita["fecha"] . " " . substr($cita["hora"], 0, 5) ?></td>
                <td><?= $cita["motivo"] ?></td>
                <td><?= ucfirst($cita["estado"]) ?></td>
                <td style="position: relative;">
                  <?php if (strtotime($cita["fecha"]) >= strtotime(date("Y-m-d")) && $cita["estado"] !== 'cancelada'): ?>
                    <button class="btn-acciones" onclick="toggleMenu(this)">⋮</button>
                    <div class="menu-acciones">
                      <a href="#"
                        onclick="mostrarEditarCita(<?= $cita['id'] ?>, '<?= $cita['fecha'] ?>', '<?= $cita['hora'] ?>', `<?= htmlspecialchars($cita['motivo'], ENT_QUOTES) ?>`)">Editar</a>
                      <a href="citaciones.php?cancelar=<?= $cita["id"] ?>"
                        onclick="return confirm('¿Cancelar esta cita?')">Eliminar</a>
                    </div>
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <!-- Formulario editar (inicialmente oculto) -->
      <div id="formEditarCita" style="display:none; margin-top:2rem;">
        <form method="POST" class="citas-formulario">
          <h3>Editar cita</h3>
          <input type="hidden" name="accion" value="editar">
          <input type="hidden" name="idCita" id="editarIdCita">
          <div class="fecha-hora">
            <input type="date" name="fecha" id="editarFecha" required>
            <input type="time" name="hora" id="editarHora" required>
          </div>
          <textarea name="motivo" id="editarMotivo" placeholder="Motivo" required></textarea>
          <button class="btn btn5" type="submit">Guardar cambios</button>
          <button type="button" class="btn_cancelar"
            onclick="document.getElementById('formEditarCita').style.display='none'">Cancelar</button>
        </form>
      </div>
    </div>
  </section>

  <?php include("includes/footer.php"); ?>

  <script src="js/citaciones.js"></script>

</body>

</html>