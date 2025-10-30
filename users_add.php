<?php
// users_add.php
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

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCedula = trim($_POST['cedula'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($newCedula === '' || $nombre === '' || $password === '') {
        $message = 'Complete todos los campos.';
    } else {
        // Insertar
        $stmt = $pdo->prepare("INSERT INTO usuarios (cedula, nombre, password) VALUES (:cedula, :nombre, :password)");
        try {
            $stmt->execute([
                ':cedula' => $newCedula,
                ':nombre' => $nombre,
                ':password' => $password
            ]);
            header('Location: users_list.php');
            exit;
        } catch (PDOException $e) {
            $message = 'Error al crear usuario (¿la cédula ya existe?).';
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Agregar Usuario - <?= APP_NAME ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
  <h2>Agregar usuario</h2>

  <?php if ($message): ?><div class="alert"><?= htmlspecialchars($message) ?></div><?php endif; ?>

  <form method="post" action="users_add.php">
    <label>Cédula <input type="text" name="cedula" required></label>
    <label>Nombre <input type="text" name="nombre" required></label>
    <label>Contraseña <input type="text" name="password" required></label>
    <button type="submit">Crear</button>
  </form>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
