<?php
require_once '../includes/auth.php';
require_once '../includes/database.php';

$stmt = $pdo->query(
  "SELECT l.*, a.FullName 
     FROM tblAdminLogs l 
     JOIN tblAdmins ad ON l.AdminID = ad.AdminID 
     JOIN tblUsers a ON ad.UserID = a.UserID
     ORDER BY l.Timestamp DESC"
);
$logs = $stmt->fetchAll();

require_once '../includes/header.php';
?>
<h2>Admin Activity Logs</h2>
<table>
  <tr><th>Time</th><th>Admin</th><th>Action</th></tr>
  <?php foreach($logs as $log): ?>
    <tr>
      <td><?= $log['Timestamp'] ?></td>
      <td><?= htmlspecialchars($log['FullName']) ?></td>
      <td><?= htmlspecialchars($log['Action']) ?></td>
    </tr>
  <?php endforeach; ?>
</table>
<?php require_once '../includes/footer.php'; ?>
