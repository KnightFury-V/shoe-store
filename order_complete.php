<?php
/**
 * Order Completion Page
 *
 * Displays a message to the user after they have completed an order.
 *
 * @package OrderCompletion
 */
session_start(); // Ensure session is started
require_once 'includes/auth.php';
require_once 'includes/header.php';
require_once 'includes/config.php';
require_once 'includes/database.php';

$orderId = $_GET['order_id'] ?? null;

// List of outlets in Copenhagen
$outlets = [
    "Nørreport Station, Copenhagen",
    "Østerbro, Copenhagen",
    "Vesterbro, Copenhagen",
    "Amager, Copenhagen",
    "Frederiksberg, Copenhagen"
];

// Handle outlet selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_outlet'])) {
    $selectedOutlet = $_POST['selected_outlet'];

    // Update the order with the selected outlet
    $stmt = $pdo->prepare("UPDATE tblOrders SET PickupOutlet = ? WHERE OrderID = ?");
    $stmt->execute([$selectedOutlet, $orderId]);

    $successMessage = "Your selected outlet has been updated successfully!";
}
?>


<h2>Order Completed</h2>
<p>Thank you! Your order ID is: <strong><?= htmlspecialchars($orderId) ?></strong></p>
<p>You can pick up your order and pay at one of the following outlets:</p>

<?php if (!empty($successMessage)): ?>
    <p class="success"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>

<form method="POST">
    <label for="outlet">Choose an outlet:</label>
    <select name="selected_outlet" id="outlet" required>
        <option value="" disabled selected>Select an outlet</option>
        <?php foreach ($outlets as $outlet): ?>
            <option value="<?= htmlspecialchars($outlet) ?>"><?= htmlspecialchars($outlet) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Confirm Outlet</button>
</form>

<a href="index.php">Back to Home</a>