<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount_price = $_POST['discount_price'];
    $category = $_POST['category'];
    $gem_type = $_POST['gem_type'];
    $size = $_POST['size'];
    $image_url = $_POST['image_url'];
    $availability = $_POST['availability'];

    $sql = "UPDATE products SET 
                name='$name',
                description='$description',
                price=$price,
                discount_price=$discount_price,
                category='$category',
                gem_type='$gem_type',
                size='$size',
                image_path='$image_url',
                availability='$availability'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Produit mis à jour avec succès.";
    } else {
        echo "Erreur de mise à jour : " . mysqli_error($conn);
    }
}
?>
