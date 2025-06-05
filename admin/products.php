<?php
session_start(); // Ensure session is started
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';

$products = $pdo->query(
    "SELECT p.*, c.CategoryName 
     FROM tblProducts p 
     LEFT JOIN tblCategories c ON p.CategoryID = c.CategoryID
     ORDER BY p.ProductID DESC"
)->fetchAll();
?>

<!-- Display Success or Error Messages -->
<?php
if (!empty($_SESSION['success_message'])): ?>
    <div id="success-modal" class="modal">
        <div class="modal-content">
            <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error_message'])): ?>
    <div id="error-modal" class="modal">
        <div class="modal-content">
            <p><?= htmlspecialchars($_SESSION['error_message']) ?></p>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<?php include 'admin_header.php'; ?>
<h2>Manage Products</h2>
<!-- Add Product Button -->
<div style="margin-top: 20px;">
    <a href="../admin/add_product.php" class="btn">Add Product</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['ProductID'] ?></td>
                <td><?= htmlspecialchars($product['ProductName']) ?></td>
                <td><?= htmlspecialchars($product['CategoryName']) ?></td>
                <td>$<?= number_format($product['Price'], 2) ?></td>
                <td><?= $product['Stock'] ?></td>
                <td>
                    <a href="../admin/edit_product.php?id=<?= $product['ProductID'] ?>" class="btn">Edit</a>
                    <a href="../admin/delete_product.php?id=<?= $product['ProductID'] ?>" class="btn btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>




<!-- Modal Styles -->
<style>
.modal {
    display: block;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

.modal-content {
    text-align: center;
}

.modal-content p {
    font-size: 1.2rem;
    margin-bottom: 20px;
}

.modal-content button {
    padding: 10px 20px;
    background-color: #0e4886;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.modal-content button:hover {
    background-color: #d67f38;
}
</style>

<!-- Modal Script -->
<script>
function closeModal() {
    document.querySelectorAll('.modal').forEach(modal => modal.style.display = 'none');
}
</script>