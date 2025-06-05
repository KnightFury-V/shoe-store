<?php
session_start(); // Ensure session is started
require_once '../includes/database.php';
require_once '../includes/auth.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_ids'])) {
    $order_ids = $_POST['order_ids'];

    // Prepare placeholders for the query
    $placeholders = implode(',', array_fill(0, count($order_ids), '?'));

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="selected_orders.csv"');

    $out = fopen('php://output', 'w');
    fputcsv($out, ['Order ID', 'OrderItemID', 'ProductName', 'Quantity', 'PriceAtPurchase']); // CSV headers

    // Fetch order items for the selected orders
    $stmt = $pdo->prepare(
        "SELECT oi.OrderID, oi.OrderItemID, p.ProductName, oi.Quantity, oi.PriceAtPurchase
         FROM tblOrderItems oi
         JOIN tblProducts p ON oi.ProductID = p.ProductID
         WHERE oi.OrderID IN ($placeholders)"
    );
    $stmt->execute($order_ids);

    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        fputcsv($out, $row);
    }

    fclose($out);

    // Set success message
    $_SESSION['success_message'] = "Selected orders exported successfully.";
    exit();
} else {
    // Redirect back to orders page if no orders are selected
    $_SESSION['error_message'] = "No orders selected for export.";
    header('Location: orders.php');
    exit();
}