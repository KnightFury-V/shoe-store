<?php
require_once '../includes/auth.php';
require_once '../includes/database.php';

session_start();

// Verify CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['admin_login_error'] = "Invalid CSRF token.";
    redirect('login.php');
    exit();
}

// Process login
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    if (password_verify($password, $admin['password'])) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_role'] = 'admin';
        $_SESSION['username'] = $admin['username'];
        redirect('dashboard.php');
    } else {
        $_SESSION['admin_login_error'] = "Invalid username or password.";
        redirect('login.php');
    }
} else {
    $_SESSION['admin_login_error'] = "Invalid username or password.";
    redirect('login.php');
}
?>