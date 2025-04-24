<?php
    require 'db_connection.php';
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
        $query = "SELECT * FROM products WHERE id = $productId";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            echo json_encode($row);
        }
    }
?>