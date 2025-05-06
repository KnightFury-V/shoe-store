<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM tblCategories WHERE CategoryID = ?");
    $stmt->execute([$id]);
}

header('Location: categories.php');
exit;
