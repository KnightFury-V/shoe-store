<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);
    
    $errors = [];
    
    // Validate name
    if (empty($name)) {
        $errors['name'] = "Please enter your name";
    }
    
    // Validate email
    if (empty($email)) {
        $errors['email'] = "Please enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    
    // Validate message
    if (empty($message)) {
        $errors['message'] = "Please enter your message";
    }
    
    if (empty($errors)) {
        // Save to file
        $file = fopen("messages.txt", "a");
        fwrite($file, "Name: $name\nEmail: $email\nMessage: $message\n\n");
        fclose($file);
        
        // Send email notification (optional)
        $to = "jayguru021@gmail.com";
        $subject = "New Message from Portfolio Contact Form";
        $headers = "From: $email\r\n";
        mail($to, $subject, $message, $headers);
        
        $success = "Thank you! Your message has been sent.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact Kabita Choudhary">
    <title>Contact | Kabita Choudhary</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="experience.php">Experience</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>

    <main class="container py-2">
        <h1 class="text-center animate">Contact Me</h1>
        
        <div class="card contact-form animate">
            <?php if (isset($success)): ?>
                <div class="success mb-2">
                    <?= $success ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="contact.php">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
                    <?php if (isset($errors['name'])): ?>
                        <small class="error"><?= $errors['name'] ?></small>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <small class="error"><?= $errors['email'] ?></small>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required><?= isset($message) ? htmlspecialchars($message) : '' ?></textarea>
                    <?php if (isset($errors['message'])): ?>
                        <small class="error"><?= $errors['message'] ?></small>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="button">Send Message</button>
            </form>
        </div>
        
        <div class="card mt-2 animate" style="animation-delay: 0.2s">
            <h2>Other Ways to Connect</h2>
            <ul class="mt-1">
                <li><i class="fas fa-envelope"></i> <a href="mailto:jayguru021@gmail.com">jayguru021@gmail.com</a></li>
                <li><i class="fas fa-phone"></i> +977 981-5186163</li>
                <li><i class="fas fa-map-marker-alt"></i> Kathmandu, Nepal</li>
            </ul>
        </div>
    </main>

    <footer>
        <div class="container text-center">
            <div class="social-links">
                <a href="mailto:jayguru021@gmail.com" aria-label="Email"><i class="fas fa-envelope"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
            </div>
            <p>&copy; 2024 Kabita Choudhary. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>