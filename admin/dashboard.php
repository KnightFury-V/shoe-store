<?php
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';

// Fetch stats
$products = $pdo->query("SELECT COUNT(*) FROM tblProducts")->fetchColumn();
$orders = $pdo->query("SELECT COUNT(*) FROM tblOrders")->fetchColumn();
$users = $pdo->query("SELECT COUNT(*) FROM tblUsers")->fetchColumn();

include 'admin_header.php';
?>
<div class="dashboard">
    <h1>Admin Dashboard</h1>
    <div class="stats">
        <div class="stat-card">
            <h3>Total Products</h3>
            <p><?= htmlspecialchars($products) ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p><?= htmlspecialchars($orders) ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Users</h3>
            <p><?= htmlspecialchars($users) ?></p>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>