<?php
session_start(); // Ensure session is started
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    $_SESSION['error_message'] = "Invalid product ID.";
    header('Location: products.php');
    exit;
}

$categories = $pdo->query("SELECT * FROM tblCategories")->fetchAll();
$product = $pdo->prepare("SELECT * FROM tblProducts WHERE ProductID = ?");
$product->execute([$id]);
$data = $product->fetch();

if (!$data) {
    $_SESSION['error_message'] = "Product not found.";
    header('Location: products.php');
    exit;
}

$error_messages = []; // Array to store field-specific error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['ProductName']);
    $desc = trim($_POST['Description']);
    $price = $_POST['Price'];
    $size = trim($_POST['Size']);
    $stock = $_POST['Stock'];
    $catId = $_POST['CategoryID'];
    $imagePath = trim($_POST['ImagePath']);

    // Validation for negative values
    if ($price < 0) {
        $error_messages['Price'] = "Price cannot be negative.";
    }
    if ($stock < 0) {
        $error_messages['Stock'] = "Stock cannot be negative.";
    }
    if ($size !== '' && $size < 0) {
        $error_messages['Size'] = "Size cannot be negative.";
    }

    // Check if the product name already exists (excluding the current product)
    if (empty($error_messages)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tblProducts WHERE ProductName = ? AND ProductID != ?");
        $stmt->execute([$name, $id]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            $error_messages['ProductName'] = "The product '$name' already exists.";
        } else {
            // Update the product
            $stmt = $pdo->prepare("UPDATE tblProducts SET CategoryID=?, ProductName=?, Description=?, Price=?, Size=?, ImagePath=?, Stock=? WHERE ProductID=?");
            $stmt->execute([$catId, $name, $desc, $price, $size, $imagePath, $stock, $id]);

            // Set success message
            $_SESSION['success_message'] = "Product '$name' updated successfully.";
            header("Location: products.php");
            exit;
        }
    }
}

require_once '../admin/admin_header.php';
?>

<h2>Edit Product</h2>

<!-- Display error message -->
<?php if (!empty($error_messages)): ?>
    <p style="color: red;">Please fix the errors below:</p>
<?php endif; ?>

<form method="post" style="display: flex; flex-direction: column; gap: 10px; max-width: 400px;">
    <label>Name:</label>
    <input type="text" name="ProductName" value="<?= htmlspecialchars($name ?? $data['ProductName']) ?>" required>
    <?php if (!empty($error_messages['ProductName'])): ?>
        <p class="field-error"><?= htmlspecialchars($error_messages['ProductName']) ?></p>
    <?php endif; ?>
    
    <label>Description:</label>
    <textarea name="Description" required><?= htmlspecialchars($desc ?? $data['Description']) ?></textarea>
    
    <label>Price:</label>
    <input type="number" step="0.01" name="Price" value="<?= htmlspecialchars($price ?? $data['Price']) ?>" required>
    <?php if (!empty($error_messages['Price'])): ?>
        <p class="field-error"><?= htmlspecialchars($error_messages['Price']) ?></p>
    <?php endif; ?>
    
    <label>Size:</label>
    <input type="number" name="Size" value="<?= htmlspecialchars($size ?? $data['Size']) ?>">
    <?php if (!empty($error_messages['Size'])): ?>
        <p class="field-error"><?= htmlspecialchars($error_messages['Size']) ?></p>
    <?php endif; ?>
    
    <label>Stock:</label>
    <input type="number" name="Stock" value="<?= htmlspecialchars($stock ?? $data['Stock']) ?>" required>
    <?php if (!empty($error_messages['Stock'])): ?>
        <p class="field-error"><?= htmlspecialchars($error_messages['Stock']) ?></p>
    <?php endif; ?>
    
    <label>Category:</label>
    <select name="CategoryID" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['CategoryID'] ?>" <?= ($catId ?? $data['CategoryID']) == $cat['CategoryID'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['CategoryName']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <label>Image Path:</label>
    <input type="text" name="ImagePath" value="<?= htmlspecialchars($imagePath ?? $data['ImagePath']) ?>" placeholder="e.g., product1.jpg" required>
    
    <div style="display: flex; gap: 10px;">
        <button type="submit" class="btn">Update Product</button>
        <a href="products.php" class="btn" style="text-decoration: none; padding: 8px 15px; background-color: #ccc; color: #000; border: 1px solid #999; border-radius: 5px; text-align: center;">Cancel</a>
    </div>
</form>

<?php require_once '../includes/footer.php'; ?>

<!-- Error Styles -->
<style>
.field-error {
    color: red;
    font-size: 0.9rem;
    margin-top: 5px;
}
</style>