<?php
require 'db_connection.php';
session_start();

$sql = "SELECT * FROM products WHERE availability = 'In Stock' AND discount_price IS NOT NULL" ;
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jewelry Dashboard</title>
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
</head>
<body>

<div class="navbar">
	<h1>Explore Our Jewelry Collection</h1>
	<h3>User:<?php echo $_SESSION['client_name'];?></h3>
    <a href="cart.php">🛒 View Cart</a>
    <a href="logout.php">🚪 Logout</a>
	
</div>


<hr>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="product">
        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Product Image">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><?php echo htmlspecialchars($row['category']) . " | " . htmlspecialchars($row['gem_type']); ?></p>
        <p><small><?php echo htmlspecialchars($row['description']); ?></small></p>
        <?php if ($row['discount_price']): ?>
            <p><del>$<?php echo $row['price']; ?></del> <strong>$<?php echo $row['discount_price']; ?></strong></p>
        <?php else: ?>
            <p><strong>$<?php echo $row['price']; ?></strong></p>
        <?php endif; ?>
        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <input type="submit" value="Add to Cart">
        </form>
    </div>
<?php endwhile; ?>


</body>
</html>
