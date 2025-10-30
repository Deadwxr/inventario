<?php
// articles_delete.php
require_once 'db.php';
require_login();

$id = $_GET['id'] ?? '';
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM articulos WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header('Location: articles_list.php');
exit;
