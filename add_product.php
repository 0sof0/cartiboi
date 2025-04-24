<?php
require 'db_connection.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['productName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['productCategory'];
    $image_url = $_POST['productImage']; // Can be a URL or path
	 $discount_price=$_POST['discount_price'];
	$size = $_POST['size'];
	$availability = $_POST['availability'];
	$gem_type=$_POST['productStone'];

    // Prepare the SQL statement to insert product
    $sql = "INSERT INTO products (name, description, price,discount_price,category,gem_type,size,image_path,availability) 
            VALUES ('$name', '$description', '$price',$discount_price, '$category','$gem_type','$size','$image_url','$availability')";
    
    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
