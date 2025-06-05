<?php
session_start();

require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

// Redirect to profile if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit();
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch user
    $stmt = $pdo->prepare("SELECT UserID, PasswordHash FROM tblUsers WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['PasswordHash'])) {
        // Login success
        $_SESSION['user_id'] = $user['UserID'];
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Email or password is incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" required placeholder="Email" value="<?= htmlspecialchars($email) ?>">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit">Login</button>
        </form>
        <p>No account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>