<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $plain_password = trim($_POST['password']);
    $fname = trim($_POST['firstName']);
    $lname = trim($_POST['lastName']);

    // Initialize error array
    $errors = [];

    // === VALIDATION ===
    if (empty($fname) || empty($lname)) {
        $errors[] = "First and last name are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($plain_password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Check if email already exists
    $check_query = "SELECT id FROM clients WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $errors[] = "This email is already registered.";
    }

    // === IF NO ERRORS, INSERT USER ===
    if (empty($errors)) {
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

        // Prepare SQL query to insert new client data
        $sql = "INSERT INTO clients (first_name, last_name, email, password_hash) 
                VALUES ('$fname', '$lname', '$email', '$hashed_password')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // Redirect to login page on success
            header("Location: login.html");
            exit;
        } else {
            $errors[] = "Registration failed: " . mysqli_error($conn);
        }
    }

    // Display errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>• $error</p>";
        }
    }
}
?>



