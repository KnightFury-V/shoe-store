<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/auth_user.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']); // Ensure the ID is an integer
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: cart.php");
    exit();
}

// Fetch product info
$items = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart']))); // Sanitize IDs
    $stmt = $pdo->query("SELECT * FROM tblProducts WHERE ProductID IN ($ids)");
    while ($row = $stmt->fetch()) {
        $qty = $_SESSION['cart'][$row['ProductID']];
        $row['quantity'] = $qty;
        $row['subtotal'] = $qty * $row['Price'];
        $total += $row['subtotal'];
        $items[] = $row;
    }
}
?>

<h2>Your Shopping Cart</h2>
<?php if (empty($items)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['ProductName']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>$<?= number_format($item['Price'], 2) ?></td>
                <td>$<?= number_format($item['subtotal'], 2) ?></td>
                <td><a href="?remove=<?= $item['ProductID'] ?>" onclick="return confirm('Are you sure you want to remove this item?');">Remove</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p><strong>Total:</strong> $<?= number_format($total, 2) ?></p>
<a href="checkout.php" class="btn">Proceed to Checkout</a>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>