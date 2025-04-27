<?php
    /*(Optional) Secure Admin Pages*/
    session_start();
    if (!isset($_SESSION['client_role']) || $_SESSION['client_role'] !== 'admin') {
        header("Location: loginForm.php");
        exit;
    }
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
    require 'db_connection.php';
    $sql = "SELECT * FROM products WHERE availability = 'In Stock'";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Admin Dashboard</title>
</head>
<body>
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
                <a href="admin.php">Admin</a>
                <a href="products.php">Products</a>
                <a href="about.html">About</a>
                <a href="contact.html">Contact</a>
                <a href="logout.php" id="logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <h1>Admin Dashboard</h1>

        <!-- Products Management -->
        <section class="management-section">
            <h2>Product Management</h2>
            <button onclick="showProductForm()" class="submit-btn">Add New Product</button>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style='color:hsl(323, 8%, 59%);'>Name</th>
                        <th style='color:hsl(323, 8%, 59%);'>Category</th>
                        <th style='color:hsl(323, 8%, 59%);'>Stone</th>
                        <th style='color:hsl(323, 8%, 59%);'>Price</th>
                        <th style='color:hsl(323, 8%, 59%);'>Discount Price</th>
                        <th style='color:hsl(323, 8%, 59%);'>Actions</th>
                    </tr>
                </thead>
                <tbody id="productsTable">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr id="product-<?php echo $row['id'];?>">
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['gem_type']); ?></td>
                            <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                            <td>$<?php echo htmlspecialchars($row['discount_price'] ?? 'No discount'); ?></td>
                            <td class="action-buttons">
                                <button class="edit-btn" onclick="editProduct(<?php echo $row['id']; ?>)">Edit</button>
                                <button class="delete-btn" onclick="deleteProduct(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div id="confirmDeleteModal" class="message" style='display:none;'>
                <p>Are you sure you want to delete this product?</p>
                <button id="confirmDeleteBtn"  style="background-color:#3f122f; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Yes, Delete</button>
                <button id="cancelDeleteBtn"  style="background-color: #a87b7b; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
            </div>
            <div class="message" id="messageDiv1"></div>
        </section>

        <!-- Feedback Management -->
        <section class="management-section">
            <h2>Customer Feedback</h2>
            <?php
            require 'db_connection.php';
            $feedbackQuery = "SELECT * FROM reviews ORDER BY review_time DESC";
            $feedbackResult = mysqli_query($conn, $feedbackQuery);
            ?>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th style='color:hsl(323, 8%, 59%);'>Email</th>
                        <th style='color:hsl(323, 8%, 59%);'>Name</th>
                        <th style='color:hsl(323, 8%, 59%);'>Subject</th>
                        <th style='color:hsl(323, 8%, 59%);'>Review</th>
                        <th style='color:hsl(323, 8%, 59%);'>Date</th>
                        <th style='color:hsl(323, 8%, 59%);'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($feedbackResult)): ?>
                        <tr data-review-id="<?php echo $row['id']; ?>">
                            <td><?php echo htmlspecialchars($row['client_email']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['review'])); ?></td>
                            <td><?php echo date('M j, Y g:i a', strtotime($row['review_time'])); ?></td>
                            <td>
                                <button class="delete-btn" onclick="deleteReview(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <!-- Review Delete Confirmation Modal -->
            <div id="confirmReviewDeleteModal" class="message" style='display:none;'>
                <p>Are you sure you want to delete this review?</p>
                <button id="confirmReviewDeleteBtn" style="background-color:#3f122f; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Yes, Delete</button>
                <button id="cancelReviewDeleteBtn" style="background-color: #a87b7b; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
            </div>
        </section>
    </div>
    <!-- Product Modal -->
    <div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        
        <!-- Progress Bar -->
        <div class="progress-bar">
            <div class="progress-step active">1</div>
            <div class="progress-step">2</div>
            <div class="progress-step">3</div>
            <div class="progress-step">4</div>
        </div>

        <!-- Step 1 - Basic Information -->
        <div class="form-step active" data-step="1">
            <h2>Product Basics</h2>
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" id="productName" name="productName" required>
            </div>
            
            <div class="form-group">
                <label for="productCategory">Accessory Type</label>
                <select id="productCategory" name="productCategory" required>
                    <option value="">Select Type</option>
                    <option value="Ring">Ring</option>
                    <option value="Earring">Earring</option>
                    <option value="Bracelet">Bracelet</option>
                    <option value="Necklace">Necklace</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="gemType">Jewelry Type</label>
                <select id="gemType" name="gemType" required>
                    <option value="">Select Gem</option>
                    <option value="Diamond">Diamond</option>
                    <option value="Emerald">Emerald</option>
                    <option value="Amethyst">Amethyst</option>
                    <option value="Sapphire">Sapphire</option>
                    <option value="Ruby">Ruby</option>
                    <option value="Opal">Opal</option>
                    <option value="Pearl">Pearl</option>
                    <option value="Lapis">Lapis</option>
                </select>
            </div>
            
            <div class="form-navigation">
                <button type="button" class="btn-nav btn-next">Next</button>
            </div>
        </div>

        <!-- Step 2 - Pricing & Availability -->
        <div class="form-step" data-step="2">
            <h2>Pricing & Stock</h2>
            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="discount_price">Discount Price ($)</label>
                <input type="number" id="discount_price" name="discount_price" step="0.01">
            </div>
            
            <div class="form-group">
                <label for="availability">Availability</label>
                <select id="availability" name="availability" required>
                    <option value="In Stock">In Stock</option>
                    <option value="Out of Stock">Out of Stock</option>
                </select>
            </div>
            
            <div class="form-navigation">
                <button type="button" class="btn-nav btn-prev">Previous</button>
                <button type="button" class="btn-nav btn-next">Next</button>
            </div>
        </div>

        <!-- Step 3 - Details -->
        <div class="form-step" data-step="3">
            <h2>Product Details</h2>
            <div class="form-group">
                <label for="size">Size</label>
                <input type="text" id="size" name="size">
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="productImage">Image URL</label>
                <input type="text" id="productImage" name="productImage" required>
            </div>
            
            <div class="form-navigation">
                <button type="button" class="btn-nav btn-prev">Previous</button>
                <button type="button" class="btn-nav btn-next">Next</button>
            </div>
        </div>

        <!-- Step 4 - Review -->
        <div class="form-step" data-step="4">
            <h2>Review Details</h2>
            <div id="reviewContent" class="review-content">
                <!-- Dynamic content will be inserted here -->
            </div>
            
            <div class="form-navigation">
                <button type="button" class="btn-nav btn-prev">Previous</button>
                <button type="button" class="btn-nav btn-submit">Submit Product</button>
            </div>
        </div>

        <!-- Confirmation -->
        <div class="confirmation-page">
            <div class="confirmation-icon">✓</div>
            <h2 class="confirmation-message">Product Added Successfully!</h2>
        </div>
    </div>
</div>
</div>

        </div>
    </div>

    <script>
  // Product Modal Management
let currentStep = 0;
let formData = {};
const steps = document.querySelectorAll('.form-step');
const progressSteps = document.querySelectorAll('.progress-step');

// Show product form modal
function showProductForm(product = null) {
    const modal = document.getElementById('productModal');
    resetFormSteps();
    
    if(product) {
        formData = product;
        populateFormFields();
    } else {
        formData = {};
    }
    
    modal.style.display = 'flex';
}

// Close modal
function closeModal() {
    document.getElementById('productModal').style.display = 'none';
    resetForm();
}

// Reset form steps
function resetFormSteps() {
    currentStep = 0;
    steps.forEach(step => step.classList.remove('active'));
    progressSteps.forEach(step => step.classList.remove('active'));
    steps[0].classList.add('active');
    progressSteps[0].classList.add('active');
}

// Update form steps
function updateFormSteps() {
    steps.forEach((step, index) => {
        step.classList.toggle('active', index === currentStep);
    });
    
    progressSteps.forEach((step, index) => {
        step.classList.toggle('active', index <= currentStep);
    });
}

// Validate current step
function validateStep(stepIndex) {
    const currentStepFields = steps[stepIndex].querySelectorAll('[required]');
    let isValid = true;
    
    currentStepFields.forEach(field => {
        if (!field.checkValidity()) {
            field.reportValidity();
            isValid = false;
        }
    });
    
    return isValid;
}

// Collect form data
function collectFormData() {
    return {
        name: document.getElementById('productName').value,
        category: document.getElementById('productCategory').value,
        gem_type: document.getElementById('gemType').value,
        price: parseFloat(document.getElementById('price').value),
        discount_price: parseFloat(document.getElementById('discount_price').value) || null,
        availability: document.getElementById('availability').value,
        size: document.getElementById('size').value,
        description: document.getElementById('description').value,
        image_path: document.getElementById('productImage').value
    };
}

// Attach event listener for the form submission
document.getElementById('productForm').addEventListener('submit', function  handleAddProduct(event) {
                event.preventDefault();  // Prevent normal form submission

                // Create FormData object from the form
                var formData = new FormData(this);

                // Make the AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'add_product.php', true);

                // Handle the response from the server
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = xhr.responseText;
                        var messageDiv = document.getElementById('messageDiv');
                        messageDiv.textContent = response; // Display the message
                        messageDiv.style.display = 'block'; // Show the message

                        // Optional: Clear the form after submission
                        document.getElementById('productForm').reset();
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
        

// Event listeners
document.addEventListener('click', (e) => {
    // Navigation buttons
    if (e.target.classList.contains('btn-next')) {
        if (validateStep(currentStep)) {
            if(currentStep === steps.length - 2) updateReviewContent();
            currentStep++;
            updateFormSteps();
        }
    }
    
    if (e.target.classList.contains('btn-prev')) {
        currentStep = Math.max(0, currentStep - 1);
        updateFormSteps();
    }
    
    // Submit button
    if (e.target.classList.contains('btn-submit')) {
        submitProduct();
    }
    
    // Close modal
    if (e.target.classList.contains('close') || e.target === document.getElementById('productModal')) {
        closeModal();
    }
});

// Edit product
    function editProduct(productId) {
        // Fetch product details from the server
        fetch(`get_product_details.php?id=${productId}`)
            .then(response => response.json())
            .then(product => {
                // Show the product form modal
                showProductForm(product);
                // Populate the form with product data
                document.getElementById('productName').value = product.name;
                document.getElementById('productCategory').value = product.category;
                document.getElementById('gemType').value = product.gem_type;
                document.getElementById('price').value = product.price;
                document.getElementById('discount_price').value = product.discount_price;
                document.getElementById('availability').value = product.availability;
                document.getElementById('size').value = product.size;
                document.getElementById('description').value = product.description;
                document.getElementById('productImage').value = product.image_url;
                // Store product ID to update it later
                formData.id = product.id;
            })
            .catch(error => console.error('Error fetching product details:', error));
    }


// Delete product
    function deleteProduct(productId) {
            // Show the confirmation modal
            var modal = document.getElementById('confirmDeleteModal');
            var messageDiv = document.getElementById('messageDiv1');

            // Show the confirmation modal
            modal.style.display = 'block';

            // Handle the "Yes, Delete" button click
            document.getElementById('confirmDeleteBtn').onclick = function() {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_product.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    // Hide the confirmation modal
                    modal.style.display = 'none';
                    // Remove the product element from the DOM
                    var productElement = document.getElementById('product-' + productId);
                    if (productElement) {
                        productElement.parentNode.removeChild(productElement);
                    }

                    // Handle success or error
                    if (xhr.status === 200) {
                        // Remove the product element from the DOM
                        var productElement = document.getElementById('product-' + productId);
                        if (productElement) {
                            productElement.parentNode.removeChild(productElement);
                        }
                        messageDiv.style.display = 'block'; // Show the message div
                        messageDiv.style.backgroundColor = 'green'; // Success background color
                        messageDiv.style.color = 'white';
                        messageDiv.textContent = xhr.responseText;  // Display success message
                        
                    } else {
                        messageDiv.style.display = 'block'; // Show the message div
                        messageDiv.style.backgroundColor = 'red'; // Error background color
                        messageDiv.style.color = 'white';
                        messageDiv.textContent = 'Error: ' + xhr.statusText; // Display error message
                    }
                };
                setTimeout(function() {
                    messageDiv.style.display = 'none'; // Hide the message div after the timeout
                }, 2000); // 3000ms = 3 seconds
                xhr.send('product_id=' + productId); // Send the product ID to the server
            };

            // Handle the "Cancel" button click
            document.getElementById('cancelDeleteBtn').onclick = function() {
                modal.style.display = 'none';  // Hide the confirmation modal
            };
        }
        // Feedback functions
        // Delete review function
        function deleteReview(reviewId) {
            // Show the confirmation modal
            var modal = document.getElementById('confirmReviewDeleteModal');
            var messageDiv = document.getElementById('messageDiv1');

            // Show the confirmation modal
            modal.style.display = 'block';

            // Handle the "Yes, Delete" button click
            document.getElementById('confirmReviewDeleteBtn').onclick = function() {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_review.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    // Hide the confirmation modal
                    modal.style.display = 'none';
                    
                    // Handle success or error
                    if (xhr.status === 200) {
                        // Remove the review row from the DOM
                        var reviewRow = document.querySelector(`tr[data-review-id="${reviewId}"]`);
                        if (reviewRow) {
                            reviewRow.parentNode.removeChild(reviewRow);
                        }
                        
                        messageDiv.style.display = 'block';
                        messageDiv.style.backgroundColor = 'green';
                        messageDiv.style.color = 'white';
                        messageDiv.textContent = xhr.responseText;
                    } else {
                        messageDiv.style.display = 'block';
                        messageDiv.style.backgroundColor = 'red';
                        messageDiv.style.color = 'white';
                        messageDiv.textContent = 'Error: ' + xhr.statusText;
                    }
                };
                
                setTimeout(function() {
                    messageDiv.style.display = 'none';
                }, 2000);
                
                xhr.send('review_id=' + reviewId);
            };

            // Handle the "Cancel" button click
            document.getElementById('cancelReviewDeleteBtn').onclick = function() {
                modal.style.display = 'none';
            };
        }
        

// ESC key to close modal
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
});
    </script>
</body>
</html>