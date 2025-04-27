<?php
require 'db_connection.php';
session_start();

<<<<<<< HEAD
$sql = "SELECT * FROM products WHERE availability = 'In Stock' AND discount_price IS NOT NULL" ;
=======
// Add authentication check
if (!isset($_SESSION['client_id'])) {
    header("Location: login.html");
    exit;
}

$sql = "SELECT * FROM products WHERE availability = 'In Stock'";
>>>>>>> d9b94525f201674ea48ff66eb38ffee228f385b9
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Jewelry Dashboard</title>
<<<<<<< HEAD
    <style>
        /*style for the discounted products from the database*/
        .product {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 15px;
            width: 220px;
            display: inline-block;
            vertical-align: top;
            text-align: center;
        }
        img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .navbar {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: right;
			display:flex;
			justify-content:space-between;
			align-items:center;
        }
        .navbar a {
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
            color: #333;
        }
    </style>
=======
    <link rel="stylesheet" href="css/style.css">
>>>>>>> d9b94525f201674ea48ff66eb38ffee228f385b9
</head>
<body>
    <nav class="navbar">
        <h1>✨ Golden Craft Jewelry</h1>
        <div class="user-section">
            <span>Welcome, <?php echo $_SESSION['client_name']; ?></span>
            <a href="cart.php" class="nav-link">🛒 Cart</a>
            <a href="logout.php" class="nav-link">🚪 Logout</a>
        </div>
    </nav>
<!-- test
test
test -->
    <main class="products-container">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars($row['image_path']); ?>" 
                     alt="<?php echo htmlspecialchars($row['name']); ?>" 
                     class="product-image">
                <div class="product-details">
                    <h3 class="product-title"><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p class="product-category">
                        <?php echo htmlspecialchars($row['category']) . ' • ' . htmlspecialchars($row['gem_type']); ?>
                    </p>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    
                    <div class="price-section">
                        <?php if ($row['discount_price']): ?>
                            <span class="original-price">$<?php echo $row['price']; ?></span>
                            <span class="current-price">$<?php echo $row['discount_price']; ?></span>
                        <?php else: ?>
                            <span class="current-price">$<?php echo $row['price']; ?></span>
                        <?php endif; ?>
                    </div>

                    <form method="POST" action="add_to_cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </main>
</body>
</html>