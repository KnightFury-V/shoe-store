<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/auth_user.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$orderId = (int)($_GET['order_id'] ?? 0);
if (!$orderId) {
    header("Location: user_orders.php");
    exit();
}

// Fetch order details
$stmt = $pdo->prepare("
    SELECT o.OrderID, o.TotalAmount, o.OrderDate, o.Status, o.PickupOutlet
    FROM tblOrders o
    WHERE o.OrderID = ? AND o.UserID = ?
");
$stmt->execute([$orderId, $_SESSION['user_id']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<p>Order not found.</p>";
    exit();
}

// Debugging: Check order details
// Uncomment the following line to debug
// var_dump($order);

// Fetch order items
$stmt = $pdo->prepare("
    SELECT oi.OrderItemID, oi.ProductID, p.ProductName, oi.Quantity, oi.PriceAtPurchase
    FROM tblOrderItems oi
    JOIN tblProducts p ON oi.ProductID = p.ProductID
    WHERE oi.OrderID = ?
");
$stmt->execute([$orderId]);
$orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debugging: Check order items
// Uncomment the following line to debug
// var_dump($orderItems);

require_once '../includes/header.php';
?>

<!-- Link External CSS -->
<link rel="stylesheet" href="../assets/css/user_order_details.css">

<h2>Order Details</h2>
<div class="order-summary">
    <p><strong>Order ID:</strong> <?= htmlspecialchars($order['OrderID']) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($order['OrderDate']) ?></p>
    <p><strong>Total:</strong> <?= isset($order['TotalAmount']) ? formatPrice($order['TotalAmount']) : 'N/A' ?></p>
    <p><strong>Status:</strong> <?= isset($order['Status']) ? htmlspecialchars($order['Status']) : 'N/A' ?></p>
    <p><strong>Pickup Outlet:</strong> <?= isset($order['PickupOutlet']) ? htmlspecialchars($order['PickupOutlet']) : 'Not Selected' ?></p>
</div>

<h3>Items</h3>
<?php if (empty($orderItems)): ?>
    <p>No items found for this order.</p>
<?php else: ?>
    <table class="order-items">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['ProductName']) ?></td>
                    <td><?= $item['Quantity'] ?></td>
                    <td><?= formatPrice($item['PriceAtPurchase']) ?></td>
                    <td><?= formatPrice($item['PriceAtPurchase'] * $item['Quantity']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="user_orders.php" class="btn">Back to Orders</a>

<?php require_once '../includes/footer.php'; ?>