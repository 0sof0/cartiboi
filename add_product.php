<?php
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['productName']);
    $category = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $gem_type = mysqli_real_escape_string($conn, $_POST['gemType']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $discount_price = mysqli_real_escape_string($conn, $_POST['discount_price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image_url = mysqli_real_escape_string($conn, $_POST['productImage']);

    $stmt = $conn->prepare("INSERT INTO products (name, category, gem_type, price, discount_price, description, image_path) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdsss", $name, $category, $gem_type, $price, $discount_price, $description, $image_url);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Product added successfully!";
        $_SESSION['status'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['status'] = "error";
    }

    $stmt->close();
    header("Location: admin.php");
    exit();
}
?>