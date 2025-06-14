<?php
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) header('Location: users.php');

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM tblUsers WHERE UserID=?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION['error_message'] = "User not found.";
    header('Location: users.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['FullName'])) {
        // Update user's full name
        $name = trim($_POST['FullName']);
        $pdo->prepare("UPDATE tblUsers SET FullName=? WHERE UserID=?")
            ->execute([$name, $id]);
        logAdminAction($_SESSION['admin_id'], "Edited user #$id name to $name");
        $_SESSION['success_message'] = "User's name updated successfully.";
    }

    if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        // Reset user's password
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Enforce password policy
        $errors = [];
        if (strlen($new_password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        if (!preg_match('/[A-Z]/', $new_password)) {
            $errors[] = "Password must include at least one uppercase letter.";
        }
        if (!preg_match('/[a-z]/', $new_password)) {
            $errors[] = "Password must include at least one lowercase letter.";
        }
        if (!preg_match('/[0-9]/', $new_password)) {
            $errors[] = "Password must include at least one number.";
        }
        if (!preg_match('/[\W]/', $new_password)) {
            $errors[] = "Password must include at least one special character.";
        }
        if ($new_password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }

        if (empty($errors)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $pdo->prepare("UPDATE tblUsers SET PasswordHash=? WHERE UserID=?")
                ->execute([$hashed_password, $id]);
            logAdminAction($_SESSION['admin_id'], "Reset password for user #$id");
            $_SESSION['success_message'] = "User's password reset successfully.";
        } else {
            $_SESSION['error_message'] = implode('<br>', $errors);
        }
    }

    header('Location: edit_user.php?id=' . $id);
    exit;
}

require_once '../admin/admin_header.php';
?>
<h2>Edit User #<?= $id ?></h2>

<!-- Display success or error messages -->
<?php if (!empty($_SESSION['success_message'])): ?>
    <p class="success"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['error_message'])): ?>
    <p class="error"><?= htmlspecialchars($_SESSION['error_message']) ?></p>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<!-- Edit User Form -->
<form method="post" style="display: flex; flex-direction: column; gap: 10px; max-width: 400px;">
  <label>Full Name:</label>
  <input name="FullName" value="<?= htmlspecialchars($user['FullName']) ?>" required>
  <button class="btn">Save</button>
</form>

<hr>

<!-- Reset Password Form -->
<h3>Reset Password</h3>
<form method="post" style="display: flex; flex-direction: column; gap: 10px; max-width: 400px;">
  <label>New Password:</label>
  <input type="password" name="new_password" placeholder="Password (8+ chars, 1 uppercase, 1 lowercase, 1 number, 1 special)" required>
  <label>Confirm Password:</label>
  <input type="password" name="confirm_password" required>
  <button class="btn">Reset Password</button>
</form>

<!-- Single Cancel Button -->
<div style="margin-top: 20px;">
  <a href="users.php" class="btn" style="text-decoration: none; padding: 8px 15px; background-color: #ccc; color: #000; border: 1px solid #999; border-radius: 5px; text-align: center;">Cancel</a>
</div>

<?php require_once '../includes/footer.php'; ?>