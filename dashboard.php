<?php
// dashboard.php
require_once 'db.php';
require_login();

$cedula = $_SESSION['cedula'];
$nombre = $_SESSION['nombre'];

// Revisar si es admin (cedula 1111 y password 1234)
$stmt = $pdo->prepare("SELECT password FROM usuarios WHERE cedula = :cedula");
$stmt->execute([':cedula' => $cedula]);
$userRow = $stmt->fetch();
$isAdmin = false;
if ($userRow && $cedula === '1111' && $userRow['password'] === '1234') {
    $isAdmin = true;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard - <?= APP_NAME ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
  <h2>Bienvenido, <?= htmlspecialchars($nombre) ?> (<?= htmlspecialchars($cedula) ?>)</h2>

  <?php if ($isAdmin): ?>
    <p>Eres administrador. Accesos:</p>
    <p>
      <a class="btn" href="users_list.php">Gestionar Usuarios</a>
      <a class="btn" href="articles_list.php">Gestionar Artículos</a>
    </p>
  <?php else: ?>
    <p>Acceso a la gestión de artículos:</p>
    <p><a class="btn" href="articles_list.php">Gestionar Artículos</a></p>
  <?php endif; ?>

</main>

<?php include 'footer.php'; ?>
</body>
</html>
