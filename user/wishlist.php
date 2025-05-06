<?php
require_once '../includes/database.php';
require_once '../includes/auth_user.php';

// Add to wishlist
if (isset($_GET['add'])) {
    $prod = (int)$_GET['add'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO tblWishlist (UserID, ProductID) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $prod]);
    header("Location: wishlist.php");
    exit;
}

// Remove from wishlist
if (isset($_GET['remove'])) {
    $prod = (int)$_GET['remove'];
    $stmt = $pdo->prepare("DELETE FROM tblWishlist WHERE UserID = ? AND ProductID = ?");
    $stmt->execute([$_SESSION['user_id'], $prod]);
    header("Location: wishlist.php");
    exit;
}

// Fetch wishlist items
$stmt = $pdo->prepare(
    "SELECT p.* FROM tblProducts p
     JOIN tblWishlist w ON p.ProductID = w.ProductID
     WHERE w.UserID = ?"
);
$stmt->execute([$_SESSION['user_id']]);
$items = $stmt->fetchAll();
?>
<h2>Your Wishlist</h2>
<?php if (!$items): ?>
  <p>No items in your wishlist.</p>
<?php else: ?>
  <ul>
    <?php foreach ($items as $i): ?>
      <li>
        <?= htmlspecialchars($i['ProductName']) ?> —
        <a href="?remove=<?= $i['ProductID'] ?>">Remove</a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
