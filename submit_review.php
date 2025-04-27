<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert the review into the database
    $sql = "INSERT INTO reviews (client_email, name, subject, review) VALUES ('$email', '$name', '$subject', '$message')";
    
    if (mysqli_query($conn, $sql)) {
        // Success - return success message to AJAX
        echo "Thank you for your feedback!";
    } else {
        // Error - return error message to AJAX
        echo "Error submitting feedback. Please try again.";
    }
    
    // Close the database connection
    mysqli_close($conn);
}
?>
