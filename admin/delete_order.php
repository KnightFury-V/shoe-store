<?php
session_start(); // Ensure session is started
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';

$orderId = (int)($_GET['id'] ?? 0);

if (!$orderId) {
    $_SESSION['error_message'] = "Invalid order ID.";
    header("Location: orders.php");
    exit();
}

try {
    // Start a transaction
    $pdo->beginTransaction();

    // Delete order items
    $stmt = $pdo->prepare("DELETE FROM tblOrderItems WHERE OrderID = ?");
    $stmt->execute([$orderId]);

    // Delete the order
    $stmt = $pdo->prepare("DELETE FROM tblOrders WHERE OrderID = ?");
    $stmt->execute([$orderId]);

    // Commit the transaction
    $pdo->commit();

    // Set success message
    $_SESSION['success_message'] = "Order #$orderId deleted successfully.";
    header("Location: orders.php");
    exit();
} catch (Exception $e) {
    // Rollback the transaction on failure
    $pdo->rollBack();
    $_SESSION['error_message'] = "Failed to delete order: " . $e->getMessage();
    header("Location: orders.php");
    exit();
}