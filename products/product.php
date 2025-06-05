<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/csrf.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) { echo "Invalid Product"; exit(); }

$stmt = $pdo->prepare("SELECT * FROM tblProducts WHERE ProductID = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) { echo "Product not found."; exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review'])) {
    verify_csrf();
    $rating = (int)$_POST['rating'];
    $text   = trim($_POST['text']);
    $stmt = $pdo->prepare(
        "INSERT INTO tblReviews (ProductID, UserID, Rating, ReviewText) 
         VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$id, $_SESSION['user_id'], $rating, $text]);
    header("Location: product.php?id=$id");
    exit;
}

// Fetch reviews
$revStmt = $pdo->prepare(
    "SELECT r.*, u.FullName FROM tblReviews r 
     JOIN tblUsers u ON r.UserID = u.UserID
     WHERE r.ProductID = ? 
     ORDER BY r.CreatedAt DESC"
);
$revStmt->execute([$id]);
$reviews = $revStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['ProductName']) ?> - Shoe Store</title>
    <link rel="stylesheet" href="../assets/css/viewProduct.css">
    
</head>
<body>
    <!-- Product Section -->
    <div class="product-container">
        <div class="product-image">
            <img src="/shoe-store/assets/images/products/<?= htmlspecialchars($product['ImagePath']) ?>" alt="<?= htmlspecialchars($product['ProductName']) ?>">
        </div>
        <div class="product-details">
            <h2><?= htmlspecialchars($product['ProductName']) ?></h2>
            <p><?= $product['Description'] ?></p>
            <p>Size: <?= $product['Size'] ?></p>
            <p class="price">Price: $<?= $product['Price'] ?></p>
            <p class="stock">In Stock: <?= $product['Stock'] ?></p>
            <a href="../user/wishlist.php?add=<?= $product['ProductID'] ?>" class="btn">Add to Wishlist</a>
        </div>
    </div>

    <!-- Review Form -->
    <div class="review-form">
        <h3>Leave a Review</h3>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <label>Rating:
                <select name="rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </label>
            <textarea name="text" required placeholder="Your review..."></textarea>
            <button type="submit" name="review">Submit Review</button>
        </form>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-container">
        <h3>Reviews</h3>
        <?php if (!$reviews): ?>
            <p class="no-reviews">No reviews yet.</p>
        <?php else: ?>
            <?php foreach ($reviews as $r): ?>
                <div class="review">
                    <div class="review-header">
                        <span class="reviewer-name"><?= htmlspecialchars($r['FullName']) ?></span>
                        <span class="review-rating"><?= $r['Rating'] ?>/5</span>
                        <span class="review-date"><?= $r['CreatedAt'] ?></span>
                    </div>
                    <div class="review-text"><?= nl2br(htmlspecialchars($r['ReviewText'])) ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>