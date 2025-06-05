<?php
session_start(); // Ensure session is started
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    $_SESSION['error_message'] = "Invalid order ID.";
    header('Location: orders.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tblOrders WHERE OrderID = ?");
$stmt->execute([$id]);
$order = $stmt->fetch();

$statuses = ['Pending', 'Processing', 'Shipped', 'Completed', 'Cancelled'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newStatus = $_POST['status'];
    $pdo->prepare("UPDATE tblOrders SET Status=? WHERE OrderID=?")
        ->execute([$newStatus, $id]);

    // Log action
    logAdminAction($_SESSION['admin_id'], "Updated order #$id status to $newStatus");

    // Set success message
    $_SESSION['success_message'] = "Order #$id status updated to '$newStatus'.";
    header('Location: orders.php');
    exit;
}

require_once '../admin/admin_header.php';
?>
<h2>Edit Order #<?= $id ?></h2>
<form method="post" style="display: flex; flex-direction: column; gap: 10px; max-width: 400px;">
  <label>Status:</label>
  <select name="status">
    <?php foreach ($statuses as $s): ?>
      <option value="<?= $s ?>" <?= $order['Status'] == $s ? 'selected' : '' ?>><?= $s ?></option>
    <?php endforeach; ?>
  </select>
  <div style="display: flex; gap: 10px;">
    <button class="btn">Save</button>
    <a href="orders.php" class="btn" style="text-decoration: none; padding: 8px 15px; background-color: #ccc; color: #000; border: 1px solid #999; border-radius: 5px; text-align: center;">Cancel</a>
  </div>
</form>
<?php require_once '../includes/footer.php'; ?>