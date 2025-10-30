<?php
// articles_edit.php
require_once 'db.php';
require_login();

$id = $_GET['id'] ?? '';
if (!$id) {
    header('Location: articles_list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM articulos WHERE id = :id");
$stmt->execute([':id' => $id]);
$art = $stmt->fetch();
if (!$art) {
    header('Location: articles_list.php');
    exit;
}

$tipos = ['PC','teclado','disco duro','mouse'];
$bodegas = ['norte','sur','oriente','occidente'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $unidades = intval($_POST['unidades'] ?? 0);
    $tipo = $_POST['tipo'] ?? '';
    $bodega = $_POST['bodega'] ?? '';

    if ($nombre === '' || $tipo === '' || $bodega === '') {
        $message = 'Complete todos los campos obligatorios.';
    } else {
        $stmt = $pdo->prepare("UPDATE articulos SET nombre = :nombre, unidades = :unidades, tipo = :tipo, bodega = :bodega, modificado_por = :modificado WHERE id = :id");
        $stmt->execute([
            ':nombre' => $nombre,
            ':unidades' => $unidades,
            ':tipo' => $tipo,
            ':bodega' => $bodega,
            ':modificado' => $_SESSION['nombre'],
            ':id' => $id
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
  <title>Editar Artículo - <?= APP_NAME ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
  <h2>Editar artículo #<?= htmlspecialchars($art['id']) ?></h2>

  <?php if ($message): ?><div class="alert"><?= htmlspecialchars($message) ?></div><?php endif; ?>

  <form method="post" action="articles_edit.php?id=<?= urlencode($art['id']) ?>">
    <label>Nombre <input type="text" name="nombre" value="<?= htmlspecialchars($art['nombre']) ?>" required></label>
    <label>Unidades <input type="number" name="unidades" value="<?= htmlspecialchars($art['unidades']) ?>" min="0" required></label>

    <label>Tipo
      <select name="tipo" required>
        <?php foreach ($tipos as $t): ?>
          <option value="<?= htmlspecialchars($t) ?>" <?= $art['tipo'] === $t ? 'selected' : '' ?>><?= htmlspecialchars($t) ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <label>Bodega
      <select name="bodega" required>
        <?php foreach ($bodegas as $b): ?>
          <option value="<?= htmlspecialchars($b) ?>" <?= $art['bodega'] === $b ? 'selected' : '' ?>><?= htmlspecialchars($b) ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <button type="submit">Guardar cambios</button>
  </form>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
