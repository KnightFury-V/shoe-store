
<?php
session_start();
 // This must be at the very top
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';


// Process actions before any output
if (isset($_GET['add'])) {
    $productId = (int)$_GET['add'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO tblWishlist (UserID, ProductID) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $productId]);
    $_SESSION['wishlist_success'] = 'Product added to wishlist!';
    header("Location: wishlist.php"); // Redirect back to refresh the page
    exit();
}

if (isset($_GET['remove'])) {
    $productId = (int)$_GET['remove'];
    $stmt = $pdo->prepare("DELETE FROM tblWishlist WHERE UserID = ? AND ProductID = ?");
    $stmt->execute([$_SESSION['user_id'], $productId]);
    $_SESSION['wishlist_success'] = 'Product removed from wishlist!';
    header("Location: wishlist.php");
    exit();
}

if (isset($_GET['add_to_cart'])) {
    $productId = (int)$_GET['add_to_cart'];
    $stmt = $pdo->prepare("SELECT ProductID, ProductName, Price, ImagePath FROM tblProducts WHERE ProductID = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity']++;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $product['ProductID'],
                'name' => $product['ProductName'],
                'price' => $product['Price'],
                'image' => $product['ImagePath'],
                'quantity' => 1,
            ];
        }

        $stmt = $pdo->prepare("DELETE FROM tblWishlist WHERE UserID = ? AND ProductID = ?");
        $stmt->execute([$_SESSION['user_id'], $productId]);

        $_SESSION['cart_success'] = 'Product moved to cart successfully!';
        $_SESSION['wishlist_success'] = 'Product moved to cart!';
        header("Location: wishlist.php");
        exit();
    }
}

// Fetch wishlist items
$stmt = $pdo->prepare("
    SELECT p.ProductID, p.ProductName, p.Price, p.ImagePath 
    FROM tblProducts p
    JOIN tblWishlist w ON p.ProductID = w.ProductID
    WHERE w.UserID = ?
");
$stmt->execute([$_SESSION['user_id']]);
$wishlistItems = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 <link rel="stylesheet" href="../assets/css/wishlist.css">
</head>
<body>
<?php require_once '../includes/header.php'; ?>

<!-- Notification Container -->
<div id="notification-container">
    <?php if (isset($_SESSION['wishlist_success'])): ?>
        <div class="notification success">
            <?php echo htmlspecialchars($_SESSION['wishlist_success']); ?>
            <button class="close-btn" onclick="this.parentElement.remove()">&times;</button>
        </div>
        <?php unset($_SESSION['wishlist_success']); ?>
    <?php endif; ?>
   
<div class="wishlist-container">
    <h2>Your Wishlist</h2>

    <?php if (empty($wishlistItems)): ?>
        <div class="wishlist-empty">
            <p>No items in your wishlist.</p>
            <a href="../index.php" class="btn-browse">Browse Products</a>
        </div>
    <?php else: ?>
        <table class="wishlist-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wishlistItems as $item): ?>
                    <tr>
                        <td data-label="Image">
                            <a href="../products/product.php?id=<?php echo $item['ProductID']; ?>">
                                <img src="../assets/images/products/<?php echo htmlspecialchars($item['ImagePath']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['ProductName']); ?>">
                            </a>
                        </td>
                        <td data-label="Product">
                            <a href="../products/product.php?id=<?php echo $item['ProductID']; ?>" class="wishlist-product-name">
                                <?php echo htmlspecialchars($item['ProductName']); ?>
                            </a>
                        </td>
                        <td data-label="Price" class="wishlist-price"><?php echo formatPrice($item['Price']); ?></td>
                        <td data-label="Actions" class="wishlist-actions">
                            <a href="?remove=<?php echo $item['ProductID']; ?>" class="btn btn-remove" 
                               onclick="return confirm('Are you sure you want to remove this item?')">
                                <i class="fas fa-trash"></i> Remove
                            </a>
                            <a href="?add_to_cart=<?php echo $item['ProductID']; ?>" class="btn btn-add-to-cart">
                                <i class="fas fa-cart-plus"></i>Cart
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Floating action button -->
        <a href="../products/" class="wishlist-fab">
            <i class="fas fa-arrow-left"></i>
        </a>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>

<script>
// Auto-hide notifications after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000); // Changed to 5 seconds (5000ms)
    });
});
</script>