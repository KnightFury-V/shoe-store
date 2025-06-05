<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$categories = $pdo->query("SELECT * FROM tblCategories")->fetchAll();
$error_messages = []; // Array to store field-specific error messages
$success_message = '';
$name = $desc = $price = $size = $stock = $catId = $imagePath = ''; // Initialize variables to retain form data

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['ProductName']);
    $desc = trim($_POST['Description']);
    $price = $_POST['Price'];
    $size = trim($_POST['Size']);
    $stock = $_POST['Stock'];
    $catId = $_POST['CategoryID'];
    $imagePath = trim($_POST['ImagePath']); // Get the image name directly from the input field

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

    // Check if the product already exists
    if (empty($error_messages)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tblProducts WHERE ProductName = ?");
        $stmt->execute([$name]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            $error_messages['ProductName'] = "The product '$name' already exists.";
        } else {
            // Insert the new product
            $stmt = $pdo->prepare("INSERT INTO tblProducts (CategoryID, ProductName, Description, Price, Size, ImagePath, Stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$catId, $name, $desc, $price, $size, $imagePath, $stock]);

            // Set success message
            $success_message = "Product '$name' added successfully!";
            // Clear form data on success
            $name = $desc = $price = $size = $stock = $catId = $imagePath = '';
        }
    }
}

require_once '../admin/admin_header.php';
?>

<!-- Link External CSS -->
<link rel="stylesheet" href="css/styles.css">

<h2 class="page-title">Add Product</h2>

<!-- Display success message in a modal -->
<?php if (!empty($success_message)): ?>
    <div id="success-modal" class="modal">
        <div class="modal-content">
            <p><?= htmlspecialchars($success_message) ?></p>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>
<?php endif; ?>

<!-- Centered Form -->
<div class="form-container">
    <form method="post" class="form">
        <label for="ProductName">Name:</label>
        <input type="text" id="ProductName" name="ProductName" value="<?= htmlspecialchars($name) ?>" required>
        <?php if (!empty($error_messages['ProductName'])): ?>
            <p class="field-error"><?= htmlspecialchars($error_messages['ProductName']) ?></p>
        <?php endif; ?>
        
        <label for="Description">Description:</label>
        <textarea id="Description" name="Description" required><?= htmlspecialchars($desc) ?></textarea>
        
        <label for="Price">Price:</label>
        <input type="number" id="Price" step="0.01" name="Price" value="<?= htmlspecialchars($price) ?>" required>
        <?php if (!empty($error_messages['Price'])): ?>
            <p class="field-error"><?= htmlspecialchars($error_messages['Price']) ?></p>
        <?php endif; ?>
        
        <label for="Size">Size:</label>
        <input type="number" id="Size" name="Size" value="<?= htmlspecialchars($size) ?>">
        <?php if (!empty($error_messages['Size'])): ?>
            <p class="field-error"><?= htmlspecialchars($error_messages['Size']) ?></p>
        <?php endif; ?>
        
        <label for="Stock">Stock:</label>
        <input type="number" id="Stock" name="Stock" value="<?= htmlspecialchars($stock) ?>" required>
        <?php if (!empty($error_messages['Stock'])): ?>
            <p class="field-error"><?= htmlspecialchars($error_messages['Stock']) ?></p>
        <?php endif; ?>
        
        <label for="CategoryID">Category:</label>
        <select id="CategoryID" name="CategoryID" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['CategoryID'] ?>" <?= $catId == $cat['CategoryID'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['CategoryName']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label for="ImagePath">Image Path:</label>
        <input type="text" id="ImagePath" name="ImagePath" value="<?= htmlspecialchars($imagePath) ?>" placeholder="e.g., product1.jpg" required>
        
        <div class="form-actions">
            <button type="submit" class="btn">Add Product</button>
            <a href="products.php" class="btn cancel-btn">Cancel</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>

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

.field-error {
    color: red;
    font-size: 0.9rem;
    margin-top: 5px;
}
</style>

<!-- Modal Script -->
<script>
function closeModal() {
    document.getElementById('success-modal').style.display = 'none';
}
</script>