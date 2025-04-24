<?php
    session_start(); // Start session

    // Check if there's a session message to display
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $message_type = $_SESSION['message_type'];
        unset($_SESSION['message']); // Clear the message after showing it
        unset($_SESSION['message_type']); // Clear the message type
    } else {
        $message = '';
        $message_type = '';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Your Carti - Login</title>
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');
            
            hamburger.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                hamburger.classList.toggle('active');
            });
            const messageDiv = document.getElementById('messageDiv');
            const messageText = "<?php echo addslashes($message); ?>";
            const messageType = "<?php echo addslashes($message_type); ?>";

            if (messageText) {
                messageDiv.textContent = messageText;
                messageDiv.classList.add(messageType); // Add the class based on message type (success/error)
                messageDiv.style.display = 'block'; // Show the message
                
                // Hide the message after 2 seconds
                setTimeout(function() {
                    messageDiv.style.display = 'none';
                }, 2000);
            }
        });
    </script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-content">
            <img src="image/logo/logo.png" alt="Your Carti Logo" class="logo">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="nav-links">
                <a href="index.html">Home</a>
                <a href="products.html">Products</a>
                <a href="about.html">About</a>
                <a href="contact.html">Contact</a>
                <a href="loginForm.php">Log in</a>
            </div>
        </div>
    </nav>
    <!-- Login Section -->
    <section class="login-section">
        <div class="login-container">
            <div class="login-content">
                <h1>Welcome Back</h1>
                <p class="login-subtitle">Sign in to your account</p>
                
                <form class="login-form" action="login.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" required 
                               placeholder="Enter your email">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required
                               placeholder="Enter your password">
                    </div>
                    
                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            Remember me
                        </label>
                        <a href="#forgot-password" class="forgot-password">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="login-button">Sign In</button>
                    
                    <p class="signup-link">
                        Don't have an account? 
                        <a href="signup.html">Create account</a>
                    </p>
                </form>
                <div class="message" id="messageDiv"></div>
            </div>
        </div>
    </section>

</body>
</html>
