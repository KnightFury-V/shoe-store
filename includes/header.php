<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Store</title>
    <link rel="stylesheet" href="/shoe-store/assets/css/style.css">
    <link rel="stylesheet" href="/shoe-store/assets/css/header.css">
    <link rel="stylesheet" href="/shoe-store/assets/css/about.css">
    <link rel="stylesheet" href="/shoe-store/assets/css/order_complete.css">
</head>
 
<body>
    <header>
        <div class="header-container">
           
            <!-- Menu Toggle Button for Mobile -->
            <div class="menu-toggle" onclick="toggleMenu()">☰</div>
               <!-- Logo Section -->
               <a href="/shoe-store/index.php" class="logo">
                        <img src="/shoe-store/assets/images/Logo.jpg" alt="Shoe Store Logo">
                    </a>

            <!-- Navigation Menu -->
            <nav>
                <ul id="menu">
                    <li><a href="/shoe-store/index.php">Home</a></li>
                    <li><a href="/shoe-store/about.php">About</a></li>
                    <li><a href="/shoe-store/contact.php">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="/shoe-store/view_cart.php">View Cart</a></li>
                    <?php endif; ?>

                 

                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li><a href="/shoe-store/view_cart.php">View Cart</a></li>
                    <?php endif; ?>
                   
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="/shoe-store/user/user_orders.php">My Orders</a></li>
                        <li><a href="/shoe-store/user/wishlist.php">My Wishlist</a></li>
                        <li><a href="/shoe-store/user/profile.php">Profile</a></li>
                        <li><a href="/shoe-store/user/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/shoe-store/user/login.php">Login</a></li>
                        <li><a href="/shoe-store/user/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <script>
        // JavaScript to toggle the menu for mobile view
        function toggleMenu() {
            const menu = document.getElementById('menu');
            menu.classList.toggle('active');
        }
    </script>
</body>
</html>