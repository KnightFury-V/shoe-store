<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

// Search functionality
$searchEmail = $_GET['search_email'] ?? '';
$query = "SELECT u.UserID, u.Email, u.FullName, u.CreatedAt, 
                 CASE WHEN a.AdminID IS NOT NULL THEN 'Admin' ELSE 'User' END AS Role
          FROM tblUsers u
          LEFT JOIN tblAdmins a ON u.UserID = a.UserID";
$params = [];

if (!empty($searchEmail)) {
    $query .= " WHERE u.Email LIKE ?";
    $params[] = '%' . $searchEmail . '%';
}

$query .= " ORDER BY u.CreatedAt DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$users = $stmt->fetchAll();

require_once '../admin/admin_header.php';
?>
<h2>Manage Users</h2>

<!-- Search Form -->
<form method="get" action="users.php" class="search-form">
    <input type="text" name="search_email" placeholder="Search by email..." value="<?= htmlspecialchars($searchEmail) ?>">
    <button type="submit" class="btn">Search</button>
</form>

<table>
  <tr><th>ID</th><th>Email</th><th>Name</th><th>Since</th><th>Role</th><th>Action</th></tr>
  <?php foreach($users as $u): ?>
    <tr>
      <td><?= $u['UserID'] ?></td>
      <td><?= htmlspecialchars($u['Email']) ?></td>
      <td><?= htmlspecialchars($u['FullName']) ?></td>
      <td><?= $u['CreatedAt'] ?></td>
      <td><?= $u['Role'] ?></td>
      <td>
        <a href="edit_user.php?id=<?= $u['UserID'] ?>" class="btn">Edit</a>
        <a href="delete_user.php?id=<?= $u['UserID'] ?>" class="btn btn-danger" onclick="return confirm('Delete user?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
