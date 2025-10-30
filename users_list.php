<?php
// users_list.php
require_once 'db.php';
require_login();

// comprobar admin
$cedula = $_SESSION['cedula'];
$stmt = $pdo->prepare("SELECT password FROM usuarios WHERE cedula = :cedula");
$stmt->execute([':cedula' => $cedula]);
$row = $stmt->fetch();
if (!($row && $cedula === '1111' && $row['password'] === '1234')) {
    // no autorizado
    header('Location: dashboard.php');
    exit;
}

$users = $pdo->query("SELECT cedula, nombre FROM usuarios ORDER BY nombre")->fetchAll();

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Usuarios - <?= APP_NAME ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
  <h2>Usuarios</h2>
  <p><a class="btn" href="users_add.php">Agregar usuario</a></p>

  <table class="tabla">
    <thead><tr><th>Cédula</th><th>Nombre</th><th>Acciones</th></tr></thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= htmlspecialchars($u['cedula']) ?></td>
          <td><?= htmlspecialchars($u['nombre']) ?></td>
          <td>
            <a href="users_edit.php?cedula=<?= urlencode($u['cedula']) ?>">Editar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</main>
<?php include 'footer.php'; ?>
</body>
</html>
