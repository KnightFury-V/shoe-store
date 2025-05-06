<?php


require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';

// Get stats
$products = $pdo->query("SELECT COUNT(*) FROM tblProducts")->fetchColumn();
$orders = $pdo->query("SELECT COUNT(*) FROM tblOrders")->fetchColumn();
$users = $pdo->query("SELECT COUNT(*) FROM tblUsers")->fetchColumn();

include '../includes/header.php';
?>
<div class="dashboard">
    <div class="stats">
        <div class="stat-card">
            <h3>Total Products</h3>
            <p><?= $products ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p><?= $orders ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Users</h3>
            <p><?= $users ?></p>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
