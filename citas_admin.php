<?php
include("includes/proteger.php");
include("database/conexion.php");

// Solo permitir administradores
if (!isset($_SESSION["idUser"]) || $_SESSION["tipo"] !== "admin") {
    header("Location: index.php");
    exit();
}

// CREAR CITA
if (isset($_POST['crear_cita'])) {
    $idUser = (int) $_POST['idUser'];
    $idPsicologo = (int) $_POST['idPsicologo'];
    $fecha = $conexion->real_escape_string($_POST['fecha']);
    $hora = $conexion->real_escape_string($_POST['hora']);
    $motivo = $conexion->real_escape_string($_POST['motivo']);

    $conexion->query("INSERT INTO citas (idUser, id_psicologo, fecha, hora, estado, motivo) 
                      VALUES ($idUser, $idPsicologo, '$fecha', '$hora', 'pendiente', '$motivo')");

    header("Location: citas_admin.php");
    exit();
}

// EDITAR CITA
if (isset($_POST['editar_cita'])) {
    $id = (int) $_POST['id'];
    $fecha = $conexion->real_escape_string($_POST['fecha']);
    $hora = $conexion->real_escape_string($_POST['hora']);
    $motivo = $conexion->real_escape_string($_POST['motivo']);

    $conexion->query("UPDATE citas SET fecha='$fecha', hora='$hora', motivo='$motivo' WHERE id=$id");

    header("Location: citas_admin.php");
    exit();
}

// ELIMINAR CITA
if (isset($_GET['eliminar'])) {
    $id = (int) $_GET['eliminar'];
    $conexion->query("DELETE FROM citas WHERE id=$id");

    header("Location: citas_admin.php");
    exit();
}

// CONFIRMAR CITA
if (isset($_GET['confirmar'])) {
    $id = (int) $_GET['confirmar'];
    $conexion->query("UPDATE citas SET estado='confirmada' WHERE id=$id");

    header("Location: citas_admin.php");
    exit();
}

// CANCELAR CITA
if (isset($_GET['cancelar'])) {
    $id = (int) $_GET['cancelar'];
    $conexion->query("UPDATE citas SET estado='cancelada' WHERE id=$id");

    header("Location: citas_admin.php");
    exit();
}

// OBTENER CITAS
$sql = "SELECT c.id, c.fecha, c.hora, c.estado, c.motivo, 
               d.nombre AS paciente_nombre, d.apellidos AS paciente_apellidos, 
               p.nombre AS psicologo_nombre, p.apellidos AS psicologo_apellidos
        FROM citas c
        JOIN users_data d ON c.idUser = d.idUser
        JOIN users_data p ON c.id_psicologo = p.idUser
        ORDER BY c.fecha ASC, c.hora ASC";
$resultado = $conexion->query($sql);

// SI SE ESTÁ EDITANDO
$editando = false;
if (isset($_GET['editar'])) {
    $editando = true;
    $idEditar = (int) $_GET['editar'];

    $consulta = $conexion->query("SELECT fecha, hora, motivo FROM citas WHERE id=$idEditar");
    $citaEditar = $consulta->fetch_assoc();
}

// OBTENER PACIENTES Y PSICÓLOGOS
$pacientes = $conexion->query("SELECT idUser, nombre, apellidos 
                                FROM users_data 
                                WHERE idUser IN (SELECT idUser FROM users_login WHERE tipo = 'user')
                                ORDER BY nombre ASC");

$psicologos = $conexion->query("SELECT d.idUser, d.nombre, d.apellidos 
                                FROM users_data d
                                JOIN users_login l ON d.idUser = l.idUser
                                WHERE l.email LIKE '%@psicologomindcore.com'
                                ORDER BY d.nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MindCore - Administrar Citas</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/975a84afb8.js" crossorigin="anonymous"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="Icon" href="img/brain-solid.svg">
    <script>
        function toggleCrearCita() {
            var form = document.getElementById('formCrearCita');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</head>

<body>
    <?php
    $pagina_actual = 'citas_admin';
    include("includes/header.php");
    ?>

    <section class="admin-wrap">
        <div class="admin-container">
            <h2>Administrar Citas</h2>

            <?php if (!$editando): ?>
                <button onclick="toggleCrearCita()" class="btn6">Crear Nueva Cita</button>

                <div id="formCrearCita" style="display:none; margin-top:20px;">
                    <div class="form-crear">
                        <form action="citas_admin.php" method="POST" class="form-grid">
                            <div>
                                <label>Paciente:</label>
                                <select name="idUser" required>
                                    <option value="">Selecciona un paciente</option>
                                    <?php while ($user = $pacientes->fetch_assoc()): ?>
                                        <option value="<?= $user['idUser'] ?>">
                                            <?= htmlspecialchars($user['nombre'] . " " . $user['apellidos']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div>
                                <label>Psicólogo:</label>
                                <select name="idPsicologo" required>
                                    <option value="">Selecciona un psicólogo</option>
                                    <?php while ($psico = $psicologos->fetch_assoc()): ?>
                                        <option value="<?= $psico['idUser'] ?>">
                                            <?= htmlspecialchars($psico['nombre'] . " " . $psico['apellidos']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div>
                                <label>Fecha:</label>
                                <input type="date" name="fecha" required>
                            </div>
                            <div>
                                <label>Hora:</label>
                                <input type="time" name="hora" required>
                            </div>
                            <div style="grid-column: span 2;">
                                <label>Motivo:</label>
                                <textarea name="motivo" rows="3" required
                                    style="width:100%; border-radius:10px; border:1px solid #ccc; padding:10px;"></textarea>
                            </div>
                            <div style="grid-column: span 2; text-align:center;">
                                <button type="submit" name="crear_cita" class="btn2">Crear Cita</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($editando): ?>
                <div class="form-editar">
                    <h3>Editar Cita</h3>
                    <form action="citas_admin.php" method="POST">
                        <input type="hidden" name="id" value="<?= $idEditar ?>">

                        <label>Fecha:</label>
                        <input type="date" name="fecha" value="<?= htmlspecialchars($citaEditar['fecha']) ?>" required>

                        <label>Hora:</label>
                        <input type="time" name="hora" value="<?= htmlspecialchars($citaEditar['hora']) ?>" required>

                        <label>Motivo:</label>
                        <textarea name="motivo" rows="4" required
                            style="width:100%; border-radius:10px; border:1px solid #ccc; padding:10px;"><?= htmlspecialchars($citaEditar['motivo']) ?></textarea>

                        <button type="submit" name="editar_cita" class="btn2">Guardar Cambios</button>
                        <a href="citas_admin.php" class="btn-danger">Cancelar</a>
                    </form>
                </div>
            <?php endif; ?>

            <div class="tabla-admin">
                <table>
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Psicólogo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Motivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["paciente_nombre"] . " " . $row["paciente_apellidos"]) ?></td>
                                <td><?= htmlspecialchars($row["psicologo_nombre"] . " " . $row["psicologo_apellidos"]) ?>
                                </td>
                                <td><?= htmlspecialchars($row["fecha"]) ?></td>
                                <td><?= htmlspecialchars($row["hora"]) ?></td>
                                <td><?= htmlspecialchars(ucfirst($row["estado"])) ?></td>
                                <td><?= htmlspecialchars($row["motivo"]) ?></td>
                                <td style="position: relative;">
                                    <button class="btn-acciones" onclick="toggleMenu(this)">⋮</button>
                                    <div class="menu-acciones">
                                        <a href="citas_admin.php?confirmar=<?= $row["id"] ?>"
                                            class="<?= ($row["estado"] == 'pendiente') ? '' : 'hidden-option' ?>"
                                            onclick="return confirm('¿Confirmar esta cita?')">Confirmar</a>

                                        <a href="citas_admin.php?cancelar=<?= $row["id"] ?>"
                                            class="<?= ($row["estado"] == 'pendiente' || $row["estado"] == 'confirmada') ? '' : 'hidden-option' ?>"
                                            onclick="return confirm('¿Cancelar esta cita?')">Cancelar</a>

                                        <a href="citas_admin.php?editar=<?= $row["id"] ?>">Editar</a>

                                        <a href="citas_admin.php?eliminar=<?= $row["id"] ?>"
                                            onclick="return confirm('¿Eliminar esta cita?')">Eliminar</a>
                                    </div>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

    <?php include("includes/footer.php"); ?>

    <script>
        function toggleMenu(button) {
            const menu = button.nextElementSibling;
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';

            // Cierra otros menús abiertos
            document.querySelectorAll('.menu-acciones').forEach(function (otherMenu) {
                if (otherMenu !== menu) {
                    otherMenu.style.display = 'none';
                }
            });
        }

        // Cierra el menú si haces click fuera
        document.addEventListener('click', function (e) {
            if (!e.target.matches('.btn-acciones')) {
                document.querySelectorAll('.menu-acciones').forEach(function (menu) {
                    menu.style.display = 'none';
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const fechaInput = document.querySelector('input[name="fecha"]');
            const horaInput = document.querySelector('input[name="hora"]');

            if (!fechaInput || !horaInput) return;

            // Establecer fecha mínima (hoy) y máxima (hoy + 1 mes)
            const now = new Date();
            const today = now.toISOString().split('T')[0];
            const maxDate = new Date();
            maxDate.setMonth(maxDate.getMonth() + 1);
            const maxDateStr = maxDate.toISOString().split('T')[0];

            fechaInput.min = today;
            fechaInput.max = maxDateStr;

            function validarFechaHora() {
                const fechaSeleccionada = new Date(fechaInput.value);
                const horaSeleccionada = horaInput.value;

                if (fechaSeleccionada.getDay() === 0 || fechaSeleccionada.getDay() === 6) {
                    alert('No se pueden agendar citas los fines de semana.');
                    fechaInput.value = '';
                    return false;
                }

                const horaParts = horaSeleccionada.split(':');
                const hora = parseInt(horaParts[0]);

                if (hora < 10 || hora >= 19) {
                    alert('El horario permitido es de 10:00 a 19:00.');
                    horaInput.value = '';
                    return false;
                }

                return true;
            }

            fechaInput.addEventListener('change', validarFechaHora);
            horaInput.addEventListener('change', validarFechaHora);
        });
    </script>


</body>

</html>