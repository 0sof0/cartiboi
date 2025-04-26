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
            
            hamburger.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                hamburger.classList.toggle('active');
            });

            // Product Modal Functionality
            /*let currentProduct = null;

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
                document.getElementById('productModal').style.display = 'block';
            };

            window.closeModal = function() {
                document.getElementById('productModal').style.display = 'none';
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
                
                alert('Added to cart!');
                closeModal();
            };

            // Close modal when clicking outside
            window.onclick = function(event) {
                if(event.target.classList.contains('product-modal')) {
                    closeModal();
                }
            }

            // Load products from localStorage
            const products = JSON.parse(localStorage.getItem('products')) || [];
            const container = document.querySelector('.products-container');
            
            container.innerHTML = products.map(product => `
                <div class="product-card" 
                     data-name="${product.name}"
                     data-price="${product.price}"
                     data-image="${product.image}"
                     data-category="${product.category}"
                     data-stone="${product.stone}"
                     onclick="showProductModal(this)">
                    <img src="${product.image}" alt="${product.name}">
                    <div class="product-info">
                        <h3>${product.name}</h3>
                        <p class="price">$${product.price}</p>
                    </div>
                </div>
            `).join('');*/
        });
    </script>
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
                <a href="index.html">Home</a>
                <a href="products.html">Products</a>
                <a href="about.html">About</a>
                <a href="contact.html">Contact</a>
                <a href="login.html">Log in</a>
            </div>
        </div>
    </nav>

    <!-- Products Main Content -->
    <main class="products-page">
        <section class="products-hero">
            <h1>Our Collection</h1>
            <p>Explore Our Premium Gemstone Jewelry</p>
        </section>

        <div class="products-wrapper">
            <!-- Filters Sidebar -->
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

            <!-- Products Container -->
            <div class="products-container">
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="product-card">
                                <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Product Image">
                                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                                <p><?php echo htmlspecialchars($row['category']) . " | " . htmlspecialchars($row['gem_type']); ?></p>
                                <p><small><?php echo htmlspecialchars($row['description']); ?></small></p>
                                <?php if ($row['discount_price']): ?>
                                    <p><del>$<?php echo $row['price']; ?></del> <strong>$<?php echo $row['discount_price']; ?></strong></p>
                                <?php else: ?>
                                    <p><strong>$<?php echo $row['price']; ?></strong></p>
                                <?php endif; ?>
                                <form id="addToCartForm" class ="addToCartForm" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <input type="submit" value="Add to Cart">
                                </form>
                        </div>
                        <?php endwhile; ?>
            </div>

        </div>
    </main>

    <!-- Product Modal -->
    <div class="product-modal" id="productModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <div class="product-modal-grid">
                <img class="modal-image" id="modalImage" src="" alt="Product Image">
                <div class="modal-details">
                    <h1 class="modal-title" id="modalTitle"></h1>
                    <p class="modal-price" id="modalPrice"></p>
                    <p class="modal-description">Premium quality gemstone jewelry handcrafted by expert artisans. Features genuine stones in premium setting.</p>
                    
                    <div class="quantity-selector">
                        <button class="quantity-btn" onclick="adjustQuantity(-1)">-</button>
                        <input type="number" class="quantity-input" id="quantity" value="1" min="1">
                        <button class="quantity-btn" onclick="adjustQuantity(1)">+</button>
                    </div>
                    
                    <button class="add-to-cart" onclick="addToCart()">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                    
                    <div class="product-specs">
                        <h3>Specifications</h3>
                        <ul id="modalSpecs">
                            <li>Material: 18K Gold</li>
                            <li>Stone Size: 1.5ct</li>
                            <li>Shipping: Free Worldwide</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>