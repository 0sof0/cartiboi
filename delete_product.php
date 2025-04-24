<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];

    $sql = "DELETE FROM products WHERE id = $product_id";

    if (mysqli_query($conn, $sql)) {
        echo "Produit supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression : " . mysqli_error($conn);
    }
}
?>
