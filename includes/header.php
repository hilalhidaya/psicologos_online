<?php if (session_status() == PHP_SESSION_NONE) session_start(); ?>

<header>
  <nav class="navbar">
    <div class="logo">
      <a href="index.php"><i class="fa-solid fa-brain"></i> MindCore</a>
    </div>

    <ul class="nav-links">
      <li><a href="index.php" class="<?php echo ($pagina_actual == 'inicio') ? 'activo' : ''; ?>">Home</a></li>
      <li><a href="blog.php" class="<?php echo ($pagina_actual == 'blog') ? 'activo' : ''; ?>">Blog</a></li>
      <li><a href="profesionales.php" class="<?php echo ($pagina_actual == 'profesionales') ? 'activo' : ''; ?>">Profesionales</a></li>
      <li><a href="contacto.php" class="<?php echo ($pagina_actual == 'contacto') ? 'activo' : ''; ?>">Contacto</a></li>

      <?php if (isset($_SESSION["idUser"]) && $_SESSION["tipo"] === 'admin'): ?>
        <li class="submenu">
          <a href="#">Administración <i class="fa-solid fa-chevron-down"></i></a>
          <ul class="submenu-items">
            <li><a href="usuarios_admin.php">Usuarios</a></li>
            <li><a href="citas_admin.php">Citas</a></li>
            <li><a href="articulos_admin.php">Artículos</a></li>
          </ul>
        </li>
      <?php endif; ?>
    </ul>

    <div class="nav-buttons">
      <?php if (isset($_SESSION["idUser"])): ?>
        <button class="btn" onclick="location.href='perfil.php'">Perfil</button>
        <?php if ($_SESSION["tipo"] === 'user'): ?>
          <button class="btn2" onclick="location.href='citaciones.php'">Citaciones</button>
        <?php endif; ?>
        <button class="btn3" onclick="location.href='logout.php'">Cerrar sesión</button>
      <?php else: ?>
        <button class="btn2" onclick="location.href='login.php'">Iniciar sesión</button>
        <button class="btn" onclick="location.href='registro.php'">Regístrate</button>
      <?php endif; ?>
    </div>
  </nav>
</header>
