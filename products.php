<?php
require 'db_connection.php';
session_start();

$sql = "SELECT * FROM products WHERE availability = 'In Stock'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Your Carti - Products</title>
    <script defer>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');
        const modal = document.getElementById('productModal');
        const overlay = document.createElement('div');
        
        overlay.className = 'modal-overlay';
        document.body.appendChild(overlay);

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            hamburger.classList.toggle('active');
        });

        let currentProduct = null;

        window.showProductModal = function(element) {
            currentProduct = {
                name: element.dataset.name,
                price: element.dataset.price,
                image: element.dataset.image,
                category: element.dataset.category,
                stone: element.dataset.stone
            };

            document.getElementById('modalImage').src = currentProduct.image;
            document.getElementById('modalTitle').textContent = currentProduct.name;
            document.getElementById('modalPrice').textContent = `$${currentProduct.price}`;
            document.getElementById('modalCategory').textContent = currentProduct.category;
            document.getElementById('modalStone').textContent = currentProduct.stone;

            modal.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        window.closeModal = function() {
            modal.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
            currentProduct = null;
        };

        window.adjustQuantity = function(change) {
            const input = document.getElementById('quantity');
            let value = parseInt(input.value) + change;
            if(value < 1) value = 1;
            input.value = value;
        };

        window.addToCart = function() {
            if(!currentProduct) return;
            
            const cartItem = {
                ...currentProduct,
                quantity: parseInt(document.getElementById('quantity').value)
            };

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push(cartItem);
            localStorage.setItem('cart', JSON.stringify(cart));
            
            const message = document.createElement('div');
            message.className = 'message';
            message.textContent = ' Added to cart!';
            document.body.appendChild(message);
            
            setTimeout(() => {
                message.style.display = 'block';
                setTimeout(() => message.remove(), 2000);
            }, 10);

            closeModal();
        };

        overlay.addEventListener('click', closeModal);
        document.addEventListener('keydown', (e) => e.key === 'Escape' && closeModal());
        modal.addEventListener('click', (e) => e.stopPropagation());
    });
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <img src="image/logo/logo.png" alt="Logo" class="logo">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="about.html">About</a>
                <a href="contact.html">Contact</a>
                <a href="loginForm.php">Log in</a>
            </div>
        </div>
    </nav>

    <main class="products-page">
        <section class="products-hero">
            <h1>Our Collection</h1>
            <p>Explore Our Premium Gemstone Jewelry</p>
        </section>

        <div class="products-wrapper">
            <aside class="filters-sidebar">
                <div class="filter-group">
                    <h3>Accessory Type</h3>
                    <div class="filter-options accessory-filter">
                        <label><input type="checkbox" name="accessory" value="All" checked> All</label>
                        <label><input type="checkbox" name="accessory" value="Ring"> Rings</label>
                        <label><input type="checkbox" name="accessory" value="Earring"> Earrings</label>
                        <label><input type="checkbox" name="accessory" value="Necklace"> Necklaces</label>
                        <label><input type="checkbox" name="accessory" value="Bracelet"> Bracelets</label>
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Stone Type</h3>
                    <div class="filter-options stone-filter">
                        <label><input type="checkbox" name="stone" value="All" checked> All</label>
                        <label><input type="checkbox" name="stone" value="Diamond"> Diamond</label>
                        <label><input type="checkbox" name="stone" value="Emerald"> Emerald</label>
                        <label><input type="checkbox" name="stone" value="Ruby"> Ruby</label>
                        <label><input type="checkbox" name="stone" value="Opal"> Opal</label>
                        <label><input type="checkbox" name="stone" value="Pearl"> Pearl</label>
                        <label><input type="checkbox" name="stone" value="Lapis"> Lapis</label>
                        <label><input type="checkbox" name="stone" value="Amathyst"> Amathyst</label>
                        <label><input type="checkbox" name="stone" value="Sapphire"> Sapphire</label>
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Price Range (Dt)</h3>
                    <div class="price-controls">
                        <input type="number" id="minPrice" placeholder="Min" min="0">
                        <input type="number" id="maxPrice" placeholder="Max" min="0">
                    </div>
                </div>
                <button class="clear-filters">Clear All Filters</button>
            </aside>

            <div class="products-container">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="product-card" 
                    data-category="<?= htmlspecialchars($row['category']) ?>"
                    data-stone="<?= htmlspecialchars($row['gem_type']) ?>"
                    data-price="<?= $row['discount_price'] ?: $row['price'] ?>"
                    data-name="<?= htmlspecialchars($row['name']) ?>"
                    data-image="<?= htmlspecialchars($row['image_path']) ?>"
                    onclick="showProductModal(this)">
                    <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Product Image">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p><?= htmlspecialchars($row['category']) ?> | <?= htmlspecialchars($row['gem_type']) ?></p>
                    <p><small><?= htmlspecialchars($row['description'] ?? 'No Description') ?></small></p>
                    <?php if ($row['discount_price']): ?>
                        <p><del>$<?= $row['price'] ?></del> <strong>$<?= $row['discount_price'] ?></strong></p>
                    <?php else: ?>
                        <p><strong>$<?= $row['price'] ?></strong></p>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

    <div class="modal-overlay"></div>
    <div class="product-modal" id="productModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <img class="modal-image" id="modalImage" src="" alt="Product Image">
            <div class="modal-details">
                <h1 class="modal-title" id="modalTitle"></h1>
                <p class="modal-price" id="modalPrice"></p>
                <div class="product-specs">
                    <h3>Details</h3>
                    <ul>
                        <li>Category: <span id="modalCategory"></span></li>
                        <li>Stone Type: <span id="modalStone"></span></li>
                        <li>Material: 18K Gold</li>
                        <li>Shipping: Free Worldwide</li>
                    </ul>
                </div>
                <div class="quantity-selector">
                    <button class="quantity-btn" onclick="adjustQuantity(-1)">-</button>
                    <input type="number" class="quantity-input" id="quantity" value="1" min="1">
                    <button class="quantity-btn" onclick="adjustQuantity(1)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart()">
                    <i class="fas fa-shopping-cart"></i>
                    Add to Cart
                </button>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>