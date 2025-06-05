<?php
session_start(); // Ensure session is started
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    $_SESSION['error_message'] = "Invalid category ID.";
    header('Location: categories.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tblCategories WHERE CategoryID = ?");
$stmt->execute([$id]);
$category = $stmt->fetch();

if (!$category) {
    $_SESSION['error_message'] = "Category not found.";
    header('Location: categories.php');
    exit;
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['CategoryName']);

    if ($name !== '') {
        // Check if the category name already exists (excluding the current category)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tblCategories WHERE CategoryName = ? AND CategoryID != ?");
        $stmt->execute([$name, $id]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            $error_message = "The category '$name' already exists.";
        } else {
            // Update the category
            $stmt = $pdo->prepare("UPDATE tblCategories SET CategoryName = ? WHERE CategoryID = ?");
            $stmt->execute([$name, $id]);

            // Set success message
            $_SESSION['success_message'] = "Category '$name' updated successfully.";
            header('Location: categories.php');
            exit;
        }
    } else {
        $error_message = "Category name cannot be empty.";
    }
}

require_once '../admin/admin_header.php';
?>

<h2>Edit Category</h2>

<?php if ($error_message): ?>
    <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
<?php endif; ?>

<form method="post" style="display: flex; flex-direction: column; gap: 10px; max-width: 400px;">
    <label>Category Name:</label>
    <input type="text" name="CategoryName" value="<?= htmlspecialchars($category['CategoryName']) ?>" required>
    <div style="display: flex; gap: 10px;">
        <button type="submit" class="btn">Update</button>
        <a href="categories.php" class="btn" style="text-decoration: none; padding: 8px 15px; background-color: #ccc; color: #000; border: 1px solid #999; border-radius: 5px; text-align: center;">Cancel</a>
    </div>
</form>

<?php require_once '../includes/footer.php'; ?>