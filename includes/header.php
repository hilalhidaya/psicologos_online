<?php if (session_status() == PHP_SESSION_NONE) session_start(); ?>
<header>
  <nav class="navbar scrolling">
    <div class="navbar_left">
      <div class="logo">
        <a href="index.php"><i class="fa-solid fa-brain"></i> MindCore</a>
      </div>
    </div>

    <div class="navbar_center">
      <ul class="nav-links">
        <li><a href="index.php" class="<?php echo ($pagina_actual == 'inicio') ? 'activo' : ''; ?>">Home</a></li>
        <li><a href="blog.php" class="<?php echo ($pagina_actual == 'blog') ? 'activo' : ''; ?>">Blog</a></li>
        <li><a href="profesionales.php" class="<?php echo ($pagina_actual == 'profesionales') ? 'activo' : ''; ?>">Profesionales</a></li>
        <li><a href="contacto.php" class="<?php echo ($pagina_actual == 'contacto') ? 'activo' : ''; ?>">Contacto</a></li>

        <?php if (isset($_SESSION["idUser"]) && $_SESSION["tipo"] === 'admin'): ?>
          <li class="submenu">
            <a href="#" class="submenu-toggle">Administración <i class="fa-solid fa-chevron-down"></i></a>
            <ul class="submenu-items">
              <li><a href="usuarios_admin.php">Usuarios</a></li>
              <li><a href="citas_admin.php">Citas</a></li>
              <li><a href="articulos_admin.php">Artículos</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <!-- Botones solo visibles en móviles -->
        <?php if (isset($_SESSION["idUser"])): ?>
          <li class="mobile-only"><a href="perfil.php">Perfil</a></li>
          <?php if ($_SESSION["tipo"] === 'user'): ?>
            <li class="mobile-only"><a href="citaciones.php">Citaciones</a></li>
          <?php endif; ?>
          <li class="mobile-only"><a href="logout.php">Cerrar sesión</a></li>
        <?php else: ?>
          <li class="mobile-only"><a href="login.php">Iniciar sesión</a></li>
          <li class="mobile-only"><a href="registro.php">Regístrate</a></li>
        <?php endif; ?>
      </ul>
    </div>

    <div class="navbar_right">
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

      <div class="menu-toggle" id="menu-toggle">
        <i class="fa-solid fa-bars"></i>
      </div>
    </div>
  </nav>
</header>

<script src="./js/menu.js"></script>