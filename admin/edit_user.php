<?php
require_once '../includes/auth.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) header('Location: users.php');

$stmt = $pdo->prepare("SELECT * FROM tblUsers WHERE UserID=?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name = $_POST['FullName'];
    $pdo->prepare("UPDATE tblUsers SET FullName=? WHERE UserID=?")
        ->execute([$name,$id]);
    logAdminAction($_SESSION['admin_id'], "Edited user #$id name to $name");
    header('Location: users.php'); exit;
}

require_once '../includes/header.php';
?>
<h2>Edit User #<?= $id ?></h2>
<form method="post">
  <label>Full Name:</label>
  <input name="FullName" value="<?= htmlspecialchars($user['FullName']) ?>">
  <button class="btn">Save</button>
</form>
<?php require_once '../includes/footer.php'; ?>
