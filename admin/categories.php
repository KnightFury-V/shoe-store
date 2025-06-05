<?php
session_start(); // Ensure session is started
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$stmt = $pdo->query("SELECT * FROM tblCategories ORDER BY CategoryName ASC");
$categories = $stmt->fetchAll();

require_once '../admin/admin_header.php';
?>

<h2>Manage Categories</h2>
<a href="add_category.php" class="btn">Add Category</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['CategoryID'] ?></td>
                <td><?= htmlspecialchars($cat['CategoryName']) ?></td>
                <td>
                    <a href="edit_category.php?id=<?= $cat['CategoryID'] ?>" class="btn">Edit</a>
                    <a href="delete_category.php?id=<?= $cat['CategoryID'] ?>" class="btn btn-danger" onclick="return confirm('Delete this category?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



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