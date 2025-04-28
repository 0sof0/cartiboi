<?php
require 'db_connection.php';
session_start();
/*test*/
$sql = "SELECT * FROM products WHERE availability = 'In Stock' AND discount_price IS NOT NULL";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');
        
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            hamburger.classList.toggle('active');
        });
    });
</script>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Your Carti - Home</title>
    
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-content">
            <img src="image/logo/logo.png" alt="Your Carti Logo" class="logo">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="about.html">About</a>
                <a href="contact.php">Contact</a>
                <a href="loginForm.php">Log in</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Discover Timeless Elegance</h1>
            <p>Premium Gemstones & Handcrafted Jewelry</p>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories">
        <h2>Our Categories</h2>
        <div class="categories-grid">
            
            <div class="category-card">
                <img src="image/background/bgc2.avif" alt="Necklaces" class="category-image">
                <h3>Necklaces</h3>
            </div>

            <div class="category-card">
                <img src="image/background/bgc.webp" alt="Rings" class="category-image">
                <h3>Rings</h3>
            </div>
            <div class="category-card">
                <img src="image/background/bgc3.webp" alt="Bracelets" class="category-image">
                <h3>Bracelets</h3>
            </div>
            <div class="category-card">
                <img src="image/background/bgc4.avif" alt="Earrings" class="category-image">
                <h3>Earrings</h3>
            </div>
            <div class="category-card">
                <img src="image/background/bgc1.jpg" alt="Gems" class="category-image">
                <h3>Natural Stones</h3>
            </div>
        </div>
    </section>
    <section class="discounted-products">
    <h2>Special Offers</h2>
    <div class="products-container"> <!-- Changed from products-grid -->
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="product-card">
            <div class="product-image-wrapper">
                <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Product Image">
            </div>
            <div class="product-details">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p class="product-category"><?= htmlspecialchars($row['category']) ?> | <?= htmlspecialchars($row['gem_type']) ?></p>
                <p><small><?= htmlspecialchars($row['description']) ?></small></p>
                <?php if ($row['discount_price']): ?>
                    <div class="price-container">
                        <del>$<?= $row['price'] ?></del> 
                        <strong>$<?= $row['discount_price'] ?></strong>
                    </div>
                <?php else: ?>
                    <div class="price-container">
                        <strong>$<?= $row['price'] ?></strong>
                    </div>
                <?php endif; ?>
                <form class="addToCartForm" method="POST">
                    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                    <input type="submit" value="Add to Cart">
                </form>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>
    <div class="message" id="messageDiv"></div> <!-- For displaying response from the server -->
    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h2>About Us</h2>
                <p>We are a leading online retailer of diamonds, offering a wide selection of high-quality gemstones at competitive prices.</p>
            </div>
            <div class="footer-section contact">
                <h2>Contact</h2>
                <p>+256 99-999-999</p>
                <p>support@diamonds.com</p>
            </div>
            <div class="footer-section location">
                <h2>Location</h2>
                <p>123 Diamond St., Ariana</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Your Carti | All Rights Reserved</p>
        </div>
    </footer>
    <script>
        document.querySelectorAll('.addToCartForm').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();  // Prevent the default form submission

            var formData = new FormData(this);  // Create FormData object from the form

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_to_cart.php', true);  // Open the request

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Handle success - show a message or update the page dynamically
                    document.getElementById('messageDiv').textContent = 'Product added to cart!';
                    document.getElementById('messageDiv').style.color = 'green';
                    document.getElementById('messageDiv').style.display = 'block';
                } else {
                    // Handle error
                    document.getElementById('messageDiv').textContent = 'Error: ' + xhr.statusText;
                    document.getElementById('messageDiv').style.color = 'red';
                    document.getElementById('messageDiv').style.display = 'block';
                }
            };

            setTimeout(function() {
                document.getElementById('messageDiv').style.display = 'none'; // Hide the message div after the timeout
            }, 1000); // 3000ms = 3 seconds

            // Send the form data via AJAX
            xhr.send(formData);
        });
    });

    </script>

</body>
</html>