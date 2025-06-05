<?php
// Set the page title
include 'includes/header.php';
$pageTitle = "Terms and Conditions - SoleMate Shoes";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        h1 {
            margin: 0;
            font-size: 2.2em;
        }
        h2 {
            color: #2c3e50;
            margin-top: 30px;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 5px;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        footer {
            margin-top: 40px;
            text-align: center;
            color: #7f8c8d;
            font-size: 0.9em;
        }
        .last-updated {
            font-style: italic;
            color: #7f8c8d;
            text-align: right;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Terms and Conditions</h1>
    </header>

    <div class="container">
        <p class="last-updated">Last updated: <?php echo date("F j, Y"); ?></p>

        <h2>1. Introduction</h2>
        <p>Welcome to SoleMate Shoes ("we," "our," or "us"). These Terms and Conditions govern your use of our website and the purchase of products from our online store. By accessing or using our website, you agree to be bound by these Terms and Conditions.</p>

        <h2>2. Orders and Purchases</h2>
        <p>All orders are subject to availability and confirmation of the order price. We reserve the right to refuse any order you place with us. In the event that we need to make a change to or cancel an order, we will attempt to notify you.</p>

        <h2>3. Pricing and Payment</h2>
        <p>All prices are displayed in US dollars (USD) and are inclusive of applicable taxes unless otherwise stated. We reserve the right to change prices for products displayed on our website at any time.</p>

        <h2>4. Shipping and Delivery</h2>
        <p>We aim to process and ship all orders within 2-3 business days. Delivery times may vary depending on your location. We are not responsible for any delays caused by the shipping carrier or customs.</p>

        <h2>5. Returns and Exchanges</h2>
        <p>We accept returns and exchanges within 30 days of purchase. Items must be unworn, in their original condition, and with all original packaging. Customers are responsible for return shipping costs unless the return is due to our error.</p>

        <h2>6. Product Descriptions</h2>
        <p>We attempt to be as accurate as possible in our product descriptions. However, we do not warrant that product descriptions or other content on our website are accurate, complete, reliable, current, or error-free.</p>

        <h2>7. Intellectual Property</h2>
        <p>All content included on this website, such as text, graphics, logos, images, and software, is the property of SoleMate Shoes or its content suppliers and protected by international copyright laws.</p>

        <h2>8. Limitation of Liability</h2>
        <p>SoleMate Shoes shall not be liable for any direct, indirect, incidental, special, or consequential damages that result from the use of, or the inability to use, our products or services.</p>

        <h2>9. Governing Law</h2>
        <p>These Terms and Conditions shall be governed by and construed in accordance with the laws of the state in which our company is registered, without regard to its conflict of law provisions.</p>

        <h2>10. Changes to Terms</h2>
        <p>We reserve the right to modify these Terms and Conditions at any time. Your continued use of our website following the posting of changes will mean you accept those changes.</p>

        <h2>11. Contact Information</h2>
        <p>If you have any questions about these Terms and Conditions, please contact us at:</p>
        <p>
            Email: support@shoestyle.com<br>
            Phone: (555) 123-4567<br>
            Address: NØRREPORT, COPENHAGEN, DENMARK, 1400
        </p>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> ShoeStyle. All rights reserved.</p>
    </footer>
</body>
</html>