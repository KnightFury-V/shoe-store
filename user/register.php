<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email           = trim($_POST['email']);
    $password        = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $name            = trim($_POST['fullname']);
    $consent         = isset($_POST['consent']); // Check if the checkbox is checked

    // Basic validation
    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must include at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must include at least one lowercase letter.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must include at least one number.";
    }
    if (!preg_match('/[\W]/', $password)) {
        $errors[] = "Password must include at least one special character.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }
    if (!$consent) {
        $errors[] = "You must agree to the Terms and Conditions.";
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT UserID FROM tblUsers WHERE Email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = "Email is already registered.";
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO tblUsers (Email, PasswordHash, FullName) VALUES (?, ?, ?)");
        $stmt->execute([$email, $hash, $name]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        header("Location: ../index.php");
        exit();
    }
}
require_once '../includes/header.php';
?>

<div class="register-container">
   <h1>Register</h1>

    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="register-form">
        <input type="text" name="fullname" placeholder="Full Name" required value="<?= htmlspecialchars($name ?? '') ?>">
        <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($email ?? '') ?>">
        <input type="password" name="password" placeholder="Password (8+ chars, 1 uppercase, 1 lowercase, 1 number, 1 special)" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <div class="consent-container">
            <label class="consent-label">
                <input type="checkbox" name="consent" <?= $consent ? 'checked' : '' ?>>
                <span class="checkmark"></span>
                I agree to the <a href="consent.php">Terms and Conditions</a>.
            </label>
        </div>

        <div class="form-actions">
            <button type="submit">Register</button>
            <a href="../index.php" class="cancel-btn">Cancel</a>
        </div>
    </form>

    <div class="login-link">
        Already have an account? <a href="login.php">Login here.</a>
    </div>
</div>