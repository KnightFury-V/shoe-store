<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$success = ''; // ✅ Initialize success message
$errors = [];  // ✅ Initialize error array

// ✅ Initialize all form variables before any POST check to prevent undefined warnings
$name = '';
$email = '';
$subject = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($name)) {
        $errors['name'] = 'Please enter your name.';
    }

    if (empty($email)) {
        $errors['email'] = 'Please enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if (empty($subject)) {
        $errors['subject'] = 'Please enter a subject.';
    }

    if (empty($message)) {
        $errors['message'] = 'Please enter your message.';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'Your message should be at least 10 characters long.';
    }

    if (empty($errors)) {
        // Send email
        $to = 'support@shoestyle.com'; // USE ANY EMAIL ADDRESS WE WANT TO RECEIVE CONTACT FORM MESSAGES
        $headers = "From: $name <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $emailBody = "You have received a new message from the contact form:\n\n";
        $emailBody .= "Name: $name\n";
        $emailBody .= "Email: $email\n";
        $emailBody .= "Subject: $subject\n\n";
        $emailBody .= "Message:\n$message\n";

        if (mail($to, "Contact Form: $subject", $emailBody, $headers)) {
            $success = 'Thank you for your message! We will get back to you soon.';
            // Clear form
            $name = $email = $subject = $message = '';
        } else {
            $errors[] = 'There was an error sending your message. Please try again later.';
        }
    }
}

require_once 'includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="display-4 mb-4">Contact Us</h1>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php elseif (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-7">
                    <form method="post" action="contact.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name *</label>
                            <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                                   id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                   id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <input type="text" class="form-control <?= isset($errors['subject']) ? 'is-invalid' : '' ?>" 
                                   id="subject" name="subject" value="<?= htmlspecialchars($subject) ?>" required>
                            <?php if (isset($errors['subject'])): ?>
                                <div class="invalid-feedback"><?= $errors['subject'] ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message *</label>
                            <textarea class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>" 
                                      id="message" name="message" rows="5" required><?= htmlspecialchars($message) ?></textarea>
                            <?php if (isset($errors['message'])): ?>
                                <div class="invalid-feedback"><?= $errors['message'] ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
                
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h3 class="h4 mb-4">Get in Touch</h3>
                            
                            <div class="mb-4">
                                <h4 class="h5">Customer Service</h4>
                                <p class="mb-1"><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                                <p class="mb-0"><i class="fas fa-envelope me-2"></i> support@shoestyle.com</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="h5">Business Hours</h4>
                                <p class="mb-1">Monday - Friday: 9:00 AM - 6:00 PM</p>
                                <p class="mb-0">Saturday: 10:00 AM - 4:00 PM</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="h5">Our Location</h4>
                                <address>
                                    <i class="fas fa-map-marker-alt me-2"></i> 
                                    NØRREPORT, COPENHAGEN<br>
                                    DENMARK, 1400
                                </address>
                            </div>
                            
                            <div>
                                <div class="d-flex gap-3">
                                    <a href="#" class="text-dark"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#" class="text-dark"><i class="fab fa-twitter fa-lg"></i></a>
                                    <a href="#" class="text-dark"><i class="fab fa-instagram fa-lg"></i></a>
                                    <a href="#" class="text-dark"><i class="fab fa-pinterest-p fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php';?>
