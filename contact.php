<!-- /*test*/ -->
<?php 
session_start(); 
// Check if there's a session message to display
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $status = $_SESSION['status'];
    unset($_SESSION['message']); // Clear the message after showing it
    unset($_SESSION['status']); // Clear the message type
} else {
    $message = '';
    $status = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Your Carti - Contact</title>
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');
            
            hamburger.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                hamburger.classList.toggle('active');
            });
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
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="about.html">About</a>
                <a href="contact.php">Contact</a>
                <a href="loginForm.php">Log in</a>
            </div>
        </div>
    </nav>

    <!-- Contact Hero Section -->
    <section class="contact-hero">
        <div class="hero-content">
            <h1>Get in Touch</h1>
            <p>We'd love to hear from you</p>
        </div>
    </section>

    <!-- Contact Content -->
    <div class="contact-container">
        <!-- Contact Form -->
        <form class="contact-form" id="contact-form" action="submit_review.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            
            <button type="submit" class="submit-btn">Send Message</button>
        </form>
        <div class="message" id="messageDiv"></div>

        <!-- Contact Info -->
        <div class="contact-info">
            <h2>Contact Information</h2>
            
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h3>Our Address</h3>
                    <p>123 Diamond Street<br>Ariana, Tunis 2080</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <div>
                    <h3>Phone Number</h3>
                    <p>+216 12 345 678</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <h3>Email Address</h3>
                    <p>contact@yourcarti.com</p>
                </div>
            </div>

            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12790.347003154863!2d10.173406968316577!3d36.86254182813461!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12e2cb7454c6ed51%3A0x683b7ab9660cfd0b!2sAriana%2C%20Tunisia!5e0!3m2!1sen!2stn!4v1717257316061!5m2!1sen!2stn" 
                        width="100%" 
                        height="250" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                </iframe>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h2>About Us</h2>
                <p>We are a leading online retailer of diamonds, offering a wide selection of high-quality gemstones at competitive prices.</p>
            </div>
            <div class="footer-section contact">
                <h2>Contact</h2>
                <p>+216 12 345 678</p>
                <p>contact@yourcarti.com</p>
            </div>
            <div class="footer-section location">
                <h2>Location</h2>
                <p>123 Diamond Street, Ariana</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Your Carti | All Rights Reserved</p>
        </div>
    </footer>
    <script>
        document.getElementById('contact-form').addEventListener('submit', function  handleAddProduct(event) {
                event.preventDefault();  // Prevent normal form submission

                // Create FormData object from the form
                var formData = new FormData(this);

                // Make the AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'submit_review.php', true);

                // Handle the response from the server
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = xhr.responseText;
                        var messageDiv = document.getElementById('messageDiv');
                        messageDiv.textContent = response; // Display the message
                        messageDiv.style.display = 'block'; // Show the message
                        messageDiv.style.backgroundColor='green';
                        messageDiv.style.color='white';

                        // Optional: Clear the form after submission
                        document.getElementById('contact-form').reset();
                    } else {
                        console.error('Error:', xhr.statusText);
                    }
                };
                setTimeout(function() {
                    messageDiv.style.display = 'none'; // Hide the message div after the timeout
                }, 2000); // 3000ms = 3 seconds

                // Send the form data
                xhr.send(formData);
            });
    </script>
</body>
</html>