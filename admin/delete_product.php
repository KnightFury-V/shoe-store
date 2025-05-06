<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM tblProducts WHERE ProductID = ?");
    $stmt->execute([$id]);
}

header("Location: products.php");
exit;
