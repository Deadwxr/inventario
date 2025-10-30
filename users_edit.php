<?php
// users_edit.php
require_once 'db.php';
require_login();

// comprobar admin
$cedula = $_SESSION['cedula'];
$stmt = $pdo->prepare("SELECT password FROM usuarios WHERE cedula = :cedula");
$stmt->execute([':cedula' => $cedula]);
$row = $stmt->fetch();
if (!($row && $cedula === '1111' && $row['password'] === '1234')) {
    header('Location: dashboard.php');
    exit;
}

$targetCedula = $_GET['cedula'] ?? '';
if (!$targetCedula) {
    header('Location: users_list.php');
    exit;
}

// Obtener usuario
$stmt = $pdo->prepare("SELECT cedula, nombre, password FROM usuarios WHERE cedula = :cedula");
$stmt->execute([':cedula' => $targetCedula]);
$user = $stmt->fetch();
if (!$user) {
    header('Location: users_list.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($nombre === '' || $password === '') {
        $message = 'Complete todos los campos.';
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = :nombre, password = :password WHERE cedula = :cedula");
        $stmt->execute([
            ':nombre' => $nombre,
            ':password' => $password,
            ':cedula' => $targetCedula
        ]);
        header('Location: users_list.php');
        exit;
    }
}

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Editar Usuario - <?= APP_NAME ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
  <h2>Editar usuario <?= htmlspecialchars($user['cedula']) ?></h2>

  <?php if ($message): ?><div class="alert"><?= htmlspecialchars($message) ?></div><?php endif; ?>

  <form method="post" action="users_edit.php?cedula=<?= urlencode($user['cedula']) ?>">
    <label>Cédula <input type="text" value="<?= htmlspecialchars($user['cedula']) ?>" disabled></label>
    <label>Nombre <input type="text" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" required></label>
    <label>Contraseña <input type="text" name="password" value="<?= htmlspecialchars($user['password']) ?>" required></label>
    <button type="submit">Guardar</button>
  </form>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
