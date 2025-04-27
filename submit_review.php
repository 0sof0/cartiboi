<?php
    session_start();
    require 'db_connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email =$_POST['email'];
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        
        
        
        $sql = "INSERT INTO reviews (client_email,name,subject,review) VALUES ('$email','$name','$subject ','$message')";
        
        if (mysqli_query($conn, $sql)) {
            // Success - redirect back to contact page with success message
            $_SESSION['message'] = "Thank you for your feedback!";
            $_SESSION['status'] = "success";
        } else {
            // Error
            $_SESSION['message'] = "Error submitting feedback. Please try again.";
            $_SESSION['status'] = "error";
        }
        
        header("Location: contact.html");
        exit();
    }
?>