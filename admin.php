


<?php
    /*(Optional) Secure Admin Pages*/
    session_start();
    if (!isset($_SESSION['client_role']) || $_SESSION['client_role'] !== 'admin') {
        header("Location: login.html");
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
                        <th>Name</th>
                        <th>Category</th>
                        <th>Stone</th>
                        <th>Price</th>
                        <th>Discount Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productsTable">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['gem_type']); ?></td>
                            <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                            <td>$<?php echo htmlspecialchars($row['discount_price']); ?></td>
                            <td class="action-buttons">
                                <button class="edit-btn" onclick="editProduct(<?php echo $row['id']; ?>)">Edit</button>
                                <button class="delete-btn" onclick="deleteProduct(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <!-- Feedback Management -->
        <section class="management-section">
            <h2>Customer Feedback</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
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

// Submit product
async function submitProduct() {
    try {
        const productData = collectFormData();
        
        const response = await fetch('add_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(productData)
        });
        
        if (!response.ok) throw new Error('Server error');
        
        const result = await response.json();
        if (result.success) {
            showConfirmation();
            setTimeout(() => {
                closeModal();
                location.reload();
            }, 2000);
        } else {
            throw new Error(result.message || 'Error saving product');
        }
    } catch (error) {
        alert(error.message);
        console.error('Error:', error);
    }
}

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
    fetch(`get_product.php?id=${productId}`)
        .then(response => response.json())
        .then(product => {
            showProductForm(product);
        })
        .catch(error => {
            alert('Error loading product: ' + error.message);
            console.error('Error:', error);
        });
}

// Delete product
function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        fetch('delete_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                throw new Error('Delete failed');
            }
        })
        .catch(error => {
            alert('Error deleting product: ' + error.message);
            console.error('Error:', error);
        });
    }
}

// ESC key to close modal
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
});
    </script>
</body>
</html>