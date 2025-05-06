<?php
require_once '../includes/auth.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

$stmt = $pdo->query(
  "SELECT o.*, u.FullName 
     FROM tblOrders o 
     LEFT JOIN tblUsers u ON o.UserID = u.UserID
     ORDER BY o.OrderDate DESC"
);
$orders = $stmt->fetchAll();

require_once '../includes/header.php';
?>
<h2>Manage Orders</h2>
<table>
  <tr><th>ID</th><th>User</th><th>Total</th><th>Date</th><th>Status</th><th>Action</th></tr>
  <?php foreach($orders as $o): ?>
    <tr>
      <td><?= $o['OrderID'] ?></td>
      <td><?= htmlspecialchars($o['FullName'] ?: 'Guest') ?></td>
      <td>$<?= number_format($o['TotalAmount'],2) ?></td>
      <td><?= $o['OrderDate'] ?></td>
      <td><?= $o['Status'] ?></td>
      <td>
        <a href="edit_order.php?id=<?= $o['OrderID'] ?>" class="btn">Edit</a>
        <a href="export_orders.php?order=<?= $o['OrderID'] ?>" class="btn">Export</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php require_once '../includes/footer.php'; ?>
