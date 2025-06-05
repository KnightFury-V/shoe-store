<?php
/**
 * Homepage - displays product catalog with search and filtering options
 *
 * Shows featured products with pagination and category filtering
 *
 * @package ShoeStore
 */
 
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

if (isset($_GET['add_to_wishlist'])) {
    $productId = (int)$_GET['add_to_wishlist'];
    if ($productId > 0 && isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO tblWishlist (UserID, ProductID) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $productId]);
        $_SESSION['wishlist_success'] = 'Product added to wishlist successfully!';
    }
    // Redirect to clear the URL parameter
    header("Location: index.php");
    exit();
}

$showCartSuccess = isset($_SESSION['cart_success']) && $_SESSION['cart_success'];
if ($showCartSuccess) {
    unset($_SESSION['cart_success']);
}
 
// Pagination settings
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 12;
$offset = ($page - 1) * $limit;
 
// Filter parameters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$minPrice = $_GET['min_price'] ?? '';
$maxPrice = $_GET['max_price'] ?? '';
 
// Get products and counts
$products = getProducts($search, $category, $minPrice, $maxPrice, $limit, $offset);
$totalProducts = countProducts($search, $category, $minPrice, $maxPrice);
$totalPages = ceil($totalProducts / $limit);
 
// Get categories for filter dropdown
$categories = getCategories();
 
// Fetch gallery images
$stmt = $pdo->query("SELECT ImagePath FROM tblProducts LIMIT 20");
$galleryImages = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
// Page title
$pageTitle = 'Home';
require_once 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/filter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    

 
<section class="hero">
    <video class="hero-video" autoplay muted loop id="heroVideo">
        <source src="assets/video1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="hero-content">
        <h1>Step Into Style</h1>
        <p>Discover our latest collection of premium shoes</p>
        <a href="#products" class="btn">Shop Now</a>
    </div>
</section>
 
<section class="search-filters">
    <form method="get" action="">
        <div class="search-bar">
            <input type="text" title="Search" name="search" placeholder="Search Your shoe..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>
        <div class="filters">
            <select name="category">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['CategoryID']; ?>" <?php echo $category == $cat['CategoryID'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat['CategoryName']); ?>
                </option>
            <?php endforeach; ?>
            </select>
            <input type="number" name="min_price" placeholder="Min price" value="<?php echo htmlspecialchars($minPrice); ?>" min="1" step="1">
            <input type="number" name="max_price" placeholder="Max price" value="<?php echo htmlspecialchars($maxPrice); ?>" min="1" step="1">
            <button type="submit" class="btn" title="filter"><i class="fas fa-filter"></i> </button>
            <?php if ($search || $category || $minPrice || $maxPrice): ?>
            <a href="index.php" class="btn">Clear Filters</a>
            <?php endif; ?>
        </div>
        <script>
            // Prevent submitting 0 or negative values for price filters
            document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.search-filters form');
            form.addEventListener('submit', function(e) {
                const minPrice = form.querySelector('input[name="min_price"]');
                const maxPrice = form.querySelector('input[name="max_price"]');
                if ((minPrice.value && minPrice.value <= 0) || (maxPrice.value && maxPrice.value <= 0)) {
                alert('Please enter a positive number for price filters.');
                e.preventDefault();
                }
            });
            });
        </script>
    </form>
</section>
 
<section id="products" class="products">
    <h2>Our Collection</h2>
    <?php if (empty($products)): ?>
        <p class="no-results">No products found. Try adjusting your search filters.</p>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="assets/images/products/<?php echo htmlspecialchars($product['ImagePath']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                        <div class="product-overlay">
                            <a href="./products/product.php?id=<?php echo $product['ProductID']; ?>" title="View item" class="btn"  ><i class="fas fa-eye"></i> </a>
                            <button class="btn add-to-cart" title="Add to Cart"  data-id="<?php echo $product['ProductID']; ?>"><i class="fas fa-shopping-cart"></i> </button>
                            <a href="user/wishlist.php?add=<?php echo $product['ProductID']; ?>" title="Add to Wishlist" class="btn"><i class="fas fa-heart"></i> </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['ProductName']); ?></h3>
                        <span class="price"><?php echo formatPrice($product['Price']); ?></span>
                        <span class="category"><?php echo htmlspecialchars($product['category_name']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
 
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" class="page-link">&laquo; Previous</a>
                <?php endif; ?>
               
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" class="page-link <?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
               
                <?php if ($page < $totalPages): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" class="page-link">Next &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</section>
 
<section id="gallery" class="gallery">
    <h2>Gallery</h2>
    <div class="gallery-container">
        <?php foreach ($galleryImages as $image): ?>
            <div class="gallery-item">
                <img src="assets/images/products/<?php echo htmlspecialchars($image['ImagePath']); ?>" alt="Gallery Image">
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const videoElement = document.getElementById('heroVideo');
    const videoSources = [
        'assets/video1.mp4',
        'assets/video2.mp4',
        'assets/video3.mp4',
        'assets/video4.mp4'
    ];
    let currentVideoIndex = 0;
 
    function changeVideo() {
        // Fade out the video
        videoElement.style.transition = 'opacity 1s';
        videoElement.style.opacity = 0;
 
        setTimeout(() => {
            // Change the video source
            currentVideoIndex = (currentVideoIndex + 1) % videoSources.length; // Cycle through videos
            videoElement.querySelector('source').src = videoSources[currentVideoIndex];
            videoElement.load(); // Reload the video element
            videoElement.play(); // Play the new video
 
            // Fade in the video
            videoElement.style.opacity = 1;
        }, 500); // Wait for fade-out transition to complete
    }
 
    // Change video every 7 seconds
    setInterval(changeVideo, 7000);
});
document.addEventListener('DOMContentLoaded', function () {
    const galleryContainer = document.querySelector('.gallery-container');

    if (!galleryContainer) {
        console.error('Gallery container not found.');
        return;
    }

    let scrollAmount = 0;
    const scrollStep = 1; // Pixels to scroll per step
    const scrollInterval = 10; // Time interval in milliseconds

    function autoScroll() {
        scrollAmount += scrollStep;
        galleryContainer.scrollLeft = scrollAmount;

        // Reset scroll position to create a loop effect
        if (scrollAmount >= galleryContainer.scrollWidth - galleryContainer.clientWidth) {
            scrollAmount = 0;   
        }
    }

    // Start auto-scrolling
    setInterval(autoScroll, scrollInterval);
});
document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');
           
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ productId }),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});

function showNotification(message, type = 'success') {
    const container = document.getElementById('notification-container');
    const notification = document.createElement('div');
    const notificationId = 'notification-' + Date.now();
    
    notification.id = notificationId;
    notification.className = `notification ${type} animated fadeInRight`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="notification-icon ${type === 'success' ? 'fa fa-check-circle' : 'fa fa-exclamation-circle'}"></i>
            <span class="notification-message">${message}</span>
        </div>
        <button class="notification-close" onclick="removeNotification('${notificationId}')">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    container.appendChild(notification);
    
    // Auto-remove after 3 seconds
    setTimeout(() => {
        removeNotification(notificationId);
    }, 3000);
}

function removeNotification(id) {
    const notification = document.getElementById(id);
    if (notification) {
        notification.classList.add('fadeOutRight');
        setTimeout(() => notification.remove(), 300);
    }
}

// Add to cart functionality
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');
            const productCard = this.closest('.product-card');
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;
            
            try {
                const response = await fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `productId=${productId}&action=add`
                });
                
                const data = await response.json();
                
                if (data.success) {
                    productCard.classList.add('added-to-cart');
                    setTimeout(() => {
                        productCard.classList.remove('added-to-cart');
                    }, 1000);
                    
                    showNotification(data.message, 'success');
                    
                    if (data.cartCount) {
                        const cartCountElements = document.querySelectorAll('.cart-count');
                        cartCountElements.forEach(el => {
                            el.textContent = data.cartCount;
                            el.classList.add('updated');
                            setTimeout(() => el.classList.remove('updated'), 500);
                        });
                    }
                } else {
                    showNotification(data.message || 'Error adding to cart', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Failed to add to cart. Please try again.', 'error');
            } finally {
                this.innerHTML = originalText;
                this.disabled = false;
            }
        });
    });
});

// Show wishlist success message if it exists
<?php if (isset($_SESSION['wishlist_success'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showNotification('<?php echo $_SESSION['wishlist_success']; ?>', 'success');
    });
<?php endif; ?>
</script>
</body>
</html>