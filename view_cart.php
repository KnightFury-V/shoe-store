<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Handle remove action before any output
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $productId = (int)$_GET['id'];
    
    if (isset($_SESSION['cart'][$productId])) {
        $productName = $_SESSION['cart'][$productId]['name'];
        unset($_SESSION['cart'][$productId]);
        $_SESSION['cart_success'] = "$productName removed from cart successfully!";
    }
    
    header("Location: view_cart.php");
    exit();
}


$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!-- CSS Links -->
<link rel="stylesheet" href="assets/css/cart.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Notification Container -->
<div id="notification-container">
    <?php if (isset($_SESSION['cart_success'])): ?>
        <div class="notification success">
            <?php echo htmlspecialchars($_SESSION['cart_success']); ?>
            <button class="close-btn" onclick="this.parentElement.remove()">&times;</button>
        </div>
        <?php unset($_SESSION['cart_success']); ?>
    <?php endif; ?>
</div>

<div class="cart-container">
    <h2>Your Cart</h2>

    <?php if (empty($cart)): ?>
        <p class="empty-cart">Your cart is empty.</p>
        <a href="index.php" class="btn btn-continue">Continue Shopping</a>
    <?php else: ?>
        <div class="table-responsive">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $id => $item): ?>
                        <tr>
                            <td data-label="Image">
                                <img src="assets/images/products/<?php echo htmlspecialchars($item['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </td>
                            <td data-label="Product"><?php echo htmlspecialchars($item['name']); ?></td>
                            <td data-label="Price"><?php echo formatPrice($item['price']); ?></td>
                            <td data-label="Quantity"><?php echo $item['quantity']; ?></td>
                            <td data-label="Total"><?php echo formatPrice($item['price'] * $item['quantity']); ?></td>
                            <td data-label="Actions" class="cart-actions">
                                <a href="view_cart.php?action=remove&id=<?php echo $id; ?>" class="btn btn-remove" 
                                   onclick="return confirm('Are you sure you want to remove this item?')">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </a>
                            </td>
                        </tr>
                        <?php $total += $item['price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="cart-summary">
            <h3>Total: <?php echo formatPrice($total); ?></h3>
            <div class="cart-buttons">
                <a href="index.php" class="btn btn-continue">Continue Shopping</a>
                <a href="checkout.php" class="btn btn-checkout">Proceed to Checkout</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Auto-hide notifications after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>