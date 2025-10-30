<?php
// articles_add.php
require_once 'db.php';
require_login();

$message = '';

$tipos = ['PC','teclado','disco duro','mouse'];
$bodegas = ['norte','sur','oriente','occidente'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $unidades = intval($_POST['unidades'] ?? 0);
    $tipo = $_POST['tipo'] ?? '';
    $bodega = $_POST['bodega'] ?? '';

    if ($nombre === '' || $tipo === '' || $bodega === '') {
        $message = 'Complete todos los campos obligatorios.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO articulos (nombre, unidades, tipo, bodega, creado_por, modificado_por) VALUES (:nombre, :unidades, :tipo, :bodega, :creado, :modificado)");
        $stmt->execute([
            ':nombre' => $nombre,
            ':unidades' => $unidades,
            ':tipo' => $tipo,
            ':bodega' => $bodega,
            ':creado' => $_SESSION['nombre'],
            ':modificado' => $_SESSION['nombre'],
        ]);
        header('Location: articles_list.php');
        exit;
    }
}

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Agregar Artículo - <?= APP_NAME ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
  <h2>Agregar artículo</h2>

  <?php if ($message): ?><div class="alert"><?= htmlspecialchars($message) ?></div><?php endif; ?>

  <form method="post" action="articles_add.php">
    <label>Nombre <input type="text" name="nombre" required></label>
    <label>Unidades <input type="number" name="unidades" value="0" min="0" required></label>

    <label>Tipo
      <select name="tipo" required>
        <option value="">--</option>
        <?php foreach ($tipos as $t): ?>
          <option value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <label>Bodega
      <select name="bodega" required>
        <option value="">--</option>
        <?php foreach ($bodegas as $b): ?>
          <option value="<?= htmlspecialchars($b) ?>"><?= htmlspecialchars($b) ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <button type="submit">Agregar</button>
  </form>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
