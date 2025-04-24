<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Registration</title>
</head>
<body>
    <h2>Register as a Client</h2>
    <form action="register.php" method="POST">
        <label>First Name:</label><br>
        <input type="text" name="fname" required><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="lname" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
