<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/csrf.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['CategoryName']);

    if ($name !== '') {
        // Check if the category already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tblCategories WHERE CategoryName = ?");
        $stmt->execute([$name]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            $error_message = "The category '$name' already exists.";
        } else {
            // Insert the new category
            $stmt = $pdo->prepare("INSERT INTO tblCategories (CategoryName) VALUES (?)");
            $stmt->execute([$name]);

            // Set success message
            $success_message = "Category '$name' added successfully!";
        }
    } else {
        $error_message = "Category name cannot be empty.";
    }
}

require_once '../admin/admin_header.php';
?>

<h2>Add New Category</h2>

<!-- Display success message in a modal -->
<?php if (!empty($success_message)): ?>
    <div id="success-modal" class="modal">
        <div class="modal-content">
            <p><?= htmlspecialchars($success_message) ?></p>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>
<?php endif; ?>

<!-- Display error message -->
<?php if ($error_message): ?>
    <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
<?php endif; ?>

<form method="post" style="display: flex; flex-direction: column; gap: 10px; max-width: 400px;">
    <label>Category Name:</label>
    <input type="text" name="CategoryName" required>
    <div style="display: flex; gap: 10px;">
        <button type="submit" class="btn">Add</button>
        <a href="categories.php" class="btn" style="text-decoration: none; padding: 8px 15px; background-color: #ccc; color: #000; border: 1px solid #999; border-radius: 5px; text-align: center;">Cancel</a>
    </div>
</form>

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
</style>

<!-- Modal Script -->
<script>
function closeModal() {
    document.getElementById('success-modal').style.display = 'none';
}
</script>