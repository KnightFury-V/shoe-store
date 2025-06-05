<?php
session_start(); // Ensure session is started
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';

$orders = $pdo->query(
    "SELECT o.*, u.FullName 
     FROM tblOrders o 
     LEFT JOIN tblUsers u ON o.UserID = u.UserID
     ORDER BY o.OrderDate DESC"
)->fetchAll();

include 'admin_header.php';
?>
<h2>Manage Orders</h2>

<!-- Export Selected Orders Form -->
<form method="POST" action="export_orders.php">
    <table>
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all" onclick="toggleSelectAll(this)"> Select All</th>
                <th>ID</th>
                <th>User</th>
                <th>Total</th>
                <th>Date</th>
                <th>Status</th>
                <th>Pickup Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><input type="checkbox" name="order_ids[]" value="<?= $order['OrderID'] ?>"></td>
                    <td><?= $order['OrderID'] ?></td>
                    <td><?= htmlspecialchars($order['FullName'] ?: 'Guest') ?></td>
                    <td>$<?= number_format($order['TotalAmount'], 2) ?></td>
                    <td><?= $order['OrderDate'] ?></td>
                    <td><?= $order['Status'] ?></td>
                    <td><?= htmlspecialchars($order['PickupOutlet'] ?: 'Not Selected') ?></td>
                    <td>
                        <a href="edit_order.php?id=<?= $order['OrderID'] ?>" class="btn">Edit</a>
                        <a href="delete_order.php?id=<?= $order['OrderID'] ?>" class="btn btn-danger" onclick="return confirm('Delete this order?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" class="btn">Export Selected Orders</button>
</form>

<script>
    // JavaScript to toggle all checkboxes
    function toggleSelectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('input[name="order_ids[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
    }
</script>



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