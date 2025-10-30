<?php
// header.php
?>
<header class="site-header">
  <div class="inner">
    <h1><a href="dashboard.php"><?= APP_NAME ?></a></h1>
    <nav>
      <?php if (is_logged_in()): ?>
        <span class="nav-user"> <?= htmlspecialchars($_SESSION['nombre']) ?> </span>
        <a href="dashboard.php">Inicio</a>
        <a href="logout.php">Salir</a>
      <?php else: ?>
        <a href="index.php">Login</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
