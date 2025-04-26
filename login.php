<?php
session_start(); // Start session
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists
    $stmt = $conn->prepare("SELECT * FROM clients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['client_id'] = $user['id'];
            $_SESSION['client_name'] = $user['first_name'];
            $_SESSION['client_role'] = $user['role'];
            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $_SESSION['message'] = "Invalid password.";
            $_SESSION['message_type'] = "error";
            header("Location: loginForm.php"); // Redirect back to login page
            exit;
        }
    } else {
        $_SESSION['message'] = "User not found.";
        $_SESSION['message_type'] = "error";
        header("Location: loginForm.php"); // Redirect back to login page
        exit;
    }
}
?>


