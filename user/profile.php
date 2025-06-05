<?php
require_once '../includes/auth_user.php';
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/csrf.php';
require_once '../includes/header.php';

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM tblUsers WHERE UserID = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    verify_csrf();
    $name = trim($_POST['fullname']);
    $stmt = $pdo->prepare("UPDATE tblUsers SET FullName = ? WHERE UserID = ?");
    $stmt->execute([$name, $_SESSION['user_id']]);
    header("Location: profile.php");
    exit;
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    verify_csrf();
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Password policy
    $password_policy = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    // Verify current password
    if (!password_verify($current_password, $user['PasswordHash'])) {
        $error = "Current password is incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New passwords do not match.";
    } elseif (!preg_match($password_policy, $new_password)) {
        $error = "New password does not meet the policy requirements.";
    } else {
        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE tblUsers SET PasswordHash = ? WHERE UserID = ?");
        $stmt->execute([$hashed_password, $_SESSION['user_id']]);
        $success = "Password updated successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="profile-container">
        <h2>Your Profile</h2>

        <!-- Display Profile Update Form -->
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <label>Full Name:
                <input name="fullname" value="<?= htmlspecialchars($user['FullName']) ?>" required>
            </label>
            <label>Email:
                <input value="<?= htmlspecialchars($user['Email']) ?>" disabled>
            </label>
            <button type="submit" name="update_profile">Update Profile</button>
        </form>

        <hr>

        <!-- Display Change Password Form -->
        <h3>Change Password</h3>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <label>Current Password:
                <input type="password" name="current_password" required>
            </label>
            <label>New Password:
                <input type="password" name="new_password" placeholder="At least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character" required>
            </label>
            <label>Confirm New Password:
                <input type="password" name="confirm_password" placeholder="Repeat new password" required>
            </label>
            <button type="submit" name="change_password">Change Password</button>
        </form>
    </div>
</body>
</html>