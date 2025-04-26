<?php
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['client_id'])) {
        // User must be logged in
        header('Location: loginForm.php');
        exit;
    }

    $client_id = $_SESSION['client_id'];
    $product_id = intval($_POST['product_id']);

    // 1. Check if client already has a cart
    $cart_query = "SELECT id FROM cart WHERE client_id = $client_id";
    $cart_result = mysqli_query($conn, $cart_query);

    if (mysqli_num_rows($cart_result) > 0) {
        $cart = mysqli_fetch_assoc($cart_result);
        $cart_id = $cart['id'];
    } else {
        // 2. Create new cart if it doesn't exist
        $create_cart_query = "INSERT INTO cart (client_id) VALUES ($client_id)";
        if (mysqli_query($conn, $create_cart_query)) {
            $cart_id = mysqli_insert_id($conn);
        } else {
            die("Failed to create cart: " . mysqli_error($conn));
        }
    }

    // 3. Insert or update product in cart_items
    $check_item_query = "SELECT quantity FROM cart_items WHERE cart_id = $cart_id AND product_id = $product_id";
    $item_result = mysqli_query($conn, $check_item_query);

    if (mysqli_num_rows($item_result) > 0) {
        // Update quantity
        $update_query = "UPDATE cart_items SET quantity = quantity + 1 WHERE cart_id = $cart_id AND product_id = $product_id";
        mysqli_query($conn, $update_query);
    } else {
        // Insert new item
        $insert_query = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES ($cart_id, $product_id, 1)";
        mysqli_query($conn, $insert_query);
    }

    /*header('Location: index.php');*/
    exit;
}
?>

