<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['client_id'])) {
    header('Location: login.php');
    exit;
}

$client_id = $_SESSION['client_id'];

// Handle removal of an item from cart
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['remove_product_id'])) {
    $remove_product_id = intval($_POST['remove_product_id']);

    // Get user's cart ID
    $cart_result = mysqli_query($conn, "SELECT id FROM cart WHERE client_id = $client_id");
    if ($cart_row = mysqli_fetch_assoc($cart_result)) {
        $cart_id = $cart_row['id'];
        // Delete item from cart_items
        mysqli_query($conn, "DELETE FROM cart_items WHERE cart_id = $cart_id AND product_id = $remove_product_id");
    }
}

// Get the user's cart and items
$cart_result = mysqli_query($conn, "SELECT id FROM cart WHERE client_id = $client_id");
if (!$cart_row = mysqli_fetch_assoc($cart_result)) {
    echo "<h2>Your cart is empty.</h2><a href='dashboard.php'>← Go back to shop</a>";
    exit;
}

$cart_id = $cart_row['id'];
$items_query = "SELECT p.*, ci.quantity 
                FROM cart_items ci 
                JOIN products p ON p.id = ci.product_id 
                WHERE ci.cart_id = $cart_id";
$result = mysqli_query($conn, $items_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
</head>
<body>
<h1>Your Cart</h1>

<?php if (mysqli_num_rows($result) === 0): ?>
    <p>Your cart is empty.</p>
    <a href="dashboard.php">← Continue Shopping</a>
<?php else: ?>
    <ul>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <li>
            <strong><?php echo htmlspecialchars($row['name']); ?></strong> –
            Quantity: <?php echo $row['quantity']; ?> –
            $<?php echo $row['discount_price'] ?? $row['price']; ?>
            (<?php echo $row['category']; ?> - <?php echo $row['gem_type']; ?>)

            <form method="POST" action="cart.php" style="display:inline;">
                <input type="hidden" name="remove_product_id" value="<?php echo $row['id']; ?>">
                <button type="submit">Remove</button>
            </form>
        </li>
    <?php endwhile; ?>
    </ul>
    <a href="dashboard.php">← Continue Shopping</a>
<?php endif; ?>
</body>
</html>



