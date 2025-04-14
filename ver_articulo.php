<?php
include('database/conexion.php');
$id = $_GET['id'];

$sql = "SELECT a.*, p.nombre AS autor 
        FROM articulos a
        JOIN psicologos p ON a.id_psicologo = p.id
        WHERE a.id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($articulo = $resultado->fetch_assoc()):
?>

<article class="articulo-detalle">
  <h1><?= htmlspecialchars($articulo['titulo']) ?></h1>
  <p><strong>Por:</strong> <?= htmlspecialchars($articulo['autor']) ?> - <?= $articulo['fecha'] ?></p>
  <div>
    <?= nl2br(htmlspecialchars($articulo['contenido'])) ?>
  </div>
</article>

<?php else: ?>
  <p>Artículo no encontrado.</p>
<?php endif; ?>
