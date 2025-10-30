<?php
// index.php
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = trim($_POST['cedula'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($cedula === '' || $password === '') {
        $message = 'Ingrese cédula y contraseña.';
    } else {
        $stmt = $pdo->prepare("SELECT cedula, nombre, password FROM usuarios WHERE cedula = :cedula");
        $stmt->execute([':cedula' => $cedula]);
        $user = $stmt->fetch();

        if ($user && $password === $user['password']) { // comparación plana, pedido explícito
            // autenticado
            $_SESSION['cedula'] = $user['cedula'];
            $_SESSION['nombre'] = $user['nombre'];
            // redirigir al dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            $message = 'Cédula o contraseña incorrecta.';
        }
    }
}

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= APP_NAME ?> - Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
  <h2>Iniciar sesión</h2>

  <?php if ($message): ?>
    <div class="alert"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <form method="post" action="index.php">
    <label>Cédula
      <input type="text" name="cedula" required>
    </label>

    <label>Contraseña
      <input type="password" name="password" required>
    </label>

    <button type="submit">Entrar</button>
  </form>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
<div class="footer-credits">
  Creado por Juan David, William, Uribe.....
</div>