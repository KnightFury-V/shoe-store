<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$stmt = $pdo->query("SELECT p.*, c.CategoryName FROM tblProducts p JOIN tblCategories c ON p.CategoryID = c.CategoryID ORDER BY p.ProductID DESC");
$products = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<h2>Manage Products</h2>
<a href="add_product.php" class="btn">Add Product</a>
<table>
    <thead>
        <tr>
            <th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $prod): ?>
            <tr>
                <td><?= $prod['ProductID'] ?></td>
                <td><?= htmlspecialchars($prod['ProductName']) ?></td>
                <td><?= htmlspecialchars($prod['CategoryName']) ?></td>
                <td><?= $prod['Price'] ?></td>
                <td><?= $prod['Stock'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $prod['ProductID'] ?>" class="btn">Edit</a>
                    <a href="delete_product.php?id=<?= $prod['ProductID'] ?>" class="btn btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
