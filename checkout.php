<?php
session_start();
require_once 'includes/config.php';
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

try {
    // Start DB Transaction
    $pdo->beginTransaction();

    // Calculate total and validate cart items
    $ids = implode(',', array_map('intval', array_keys($cart))); // Ensure IDs are integers
    $stmt = $pdo->query("SELECT * FROM tblProducts WHERE ProductID IN ($ids)");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($products)) {
        throw new Exception("Invalid cart items.");
    }

    foreach ($products as $product) {
        $productId = $product['ProductID'];
        $quantity = $cart[$productId]['quantity'];

        // Check if stock is sufficient
        if ($product['Stock'] < $quantity) {
            throw new Exception("Insufficient stock for product: " . htmlspecialchars($product['ProductName']));
        }

        $total += $product['Price'] * $quantity;
    }

    // Insert order
    $stmt = $pdo->prepare("INSERT INTO tblOrders (UserID, TotalAmount, OrderDate) VALUES (?, ?, NOW())");
    $stmt->execute([$userId, $total]);
    $orderId = $pdo->lastInsertId();

    // Insert order items and update stock
    $stmtOrderItems = $pdo->prepare("INSERT INTO tblOrderItems (OrderID, ProductID, Quantity, PriceAtPurchase) VALUES (?, ?, ?, ?)");
    $stmtUpdateStock = $pdo->prepare("UPDATE tblProducts SET Stock = Stock - ? WHERE ProductID = ?");

    foreach ($products as $product) {
        $productId = $product['ProductID'];
        $quantity = $cart[$productId]['quantity'];
        $price = $product['Price'];

        // Insert order item
        $stmtOrderItems->execute([$orderId, $productId, $quantity, $price]);

        // Update stock
        $stmtUpdateStock->execute([$quantity, $productId]);
    }

    // Commit transaction
    $pdo->commit();

    // Clear the cart
    unset($_SESSION['cart']);

    // Redirect to order complete page
    header("Location: order_complete.php?order_id=$orderId");
    exit();

} catch (Exception $e) {
    // Rollback transaction on failure
    $pdo->rollBack();
    echo "Checkout failed: " . $e->getMessage();
}
?>