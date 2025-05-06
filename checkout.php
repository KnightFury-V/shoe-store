<?php
session_start();
require_once 'includes/database.php';
require_once 'includes/auth_user.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: user/login.php");
    exit();
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit();
}

$userId = $_SESSION['user_id'];
$total = 0;
$cart = $_SESSION['cart'];

// Start DB Transaction
$pdo->beginTransaction();

try {
    // Calculate total
    $ids = implode(',', array_keys($cart));
    $stmt = $pdo->query("SELECT * FROM tblProducts WHERE ProductID IN ($ids)");
    $products = $stmt->fetchAll();

    foreach ($products as $product) {
        $qty = $cart[$product['ProductID']];
        $total += $product['Price'] * $qty;
    }

    // Insert order
    $stmt = $pdo->prepare("INSERT INTO tblOrders (UserID, TotalAmount) VALUES (?, ?)");
    $stmt->execute([$userId, $total]);
    $orderId = $pdo->lastInsertId();

    // Insert order items
    $stmt = $pdo->prepare("INSERT INTO tblOrderItems (OrderID, ProductID, Quantity, PriceAtPurchase) VALUES (?, ?, ?, ?)");
    foreach ($products as $product) {
        $stmt->execute([$orderId, $product['ProductID'], $cart[$product['ProductID']], $product['Price']]);
    }

    $pdo->commit();
    unset($_SESSION['cart']);
    header("Location: order_complete.php?order_id=$orderId");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Checkout failed: " . $e->getMessage();
}
?>
