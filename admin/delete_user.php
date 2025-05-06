<?php
require_once '../includes/auth.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $pdo->prepare("DELETE FROM tblUsers WHERE UserID=?")->execute([$id]);
    logAdminAction($_SESSION['admin_id'], "Deleted user #$id");
}
header('Location: users.php');
exit;
