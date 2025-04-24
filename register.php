<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $plain_password = trim($_POST['password']);
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $country = trim($_POST['country']);
    $postal = trim($_POST['postal']);

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

    if (!preg_match('/^\d{10,15}$/', $phone)) {
        $errors[] = "Phone number must be numeric and between 10 to 15 digits.";
    }

    if (empty($address) || empty($city) || empty($state) || empty($country) || empty($postal)) {
        $errors[] = "Complete address must be provided.";
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
        $sql = "INSERT INTO clients (first_name, last_name, email, password_hash, phone, address, city, state, country, postal_code) 
                VALUES ('$fname', '$lname', '$email', '$hashed_password', '$phone', '$address', '$city', '$state', '$country', '$postal')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // Redirect to login page on success
            header("Location: FormLogin.php");
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



