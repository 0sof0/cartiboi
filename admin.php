<?php
session_start();
if (!isset($_SESSION['client_role']) || $_SESSION['client_role'] !== 'admin') {
    header("Location: loginForm.php");
    exit;
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $status = $_SESSION['status'];
    unset($_SESSION['message']);
    unset($_SESSION['status']);
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
                <a href="products.php">Products</a>
                <a href="about.html">About</a>
                <a href="contact.php">Contact</a>
                <a href="logout.php" id="logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <?php if($message): ?>
        <div class="message <?php echo $status ?>">
            <?php echo $message ?>
        </div>
        <?php endif; ?>

        <h1>Admin Dashboard</h1>

        <section class="management-section">
            <h2>Product Management</h2>
            <button class="submit-btn" onclick="showProductForm()">Add New Product</button>
            
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
            
            <div id="confirmDeleteModal" class="message" style="display:none;">
                <p>Are you sure you want to delete this product?</p>
                <button id="confirmDeleteBtn">Yes, Delete</button>
                <button id="cancelDeleteBtn">Cancel</button>
            </div>
        </section>

        <!-- Product Modal Structure -->
        <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form id="productForm" method="POST">
                    <div class="form-step active" data-step="1">
                        <h2>Product Basics</h2>
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="productName" required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="productCategory" required>
                                <option value="Ring">Ring</option>
                                <option value="Earring">Earring</option>
                                <option value="Bracelet">Bracelet</option>
                                <option value="Necklace">Necklace</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Gem Type</label>
                            <select name="gemType" required>
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
                    </div>

                    <div class="form-step" data-step="2">
                        <h2>Pricing</h2>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Discount Price</label>
                            <input type="number" name="discount_price" step="0.01">
                        </div>
                    </div>

                    <div class="form-step" data-step="3">
                        <h2>Details</h2>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Image URL</label>
                            <input type="text" name="productImage" required>
                        </div>
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn-prev">Previous</button>
                        <button type="button" class="btn-next">Next</button>
                        <button type="submit" class="btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    let currentStep = 0;
    const formSteps = document.querySelectorAll('.form-step');
    const prevBtn = document.querySelector('.btn-prev');
    const nextBtn = document.querySelector('.btn-next');
    const submitBtn = document.querySelector('.btn-submit');
    const productModal = document.getElementById('productModal');

    function showProductForm() {
        productModal.style.display = 'block';
        resetForm();
        updateButtonVisibility();
    }

    function closeModal() {
        productModal.style.display = 'none';
        resetForm();
    }

    function resetForm() {
    currentStep = 0;
    formSteps.forEach(step => {
        step.classList.remove('active');
        step.style.display = 'none';
    });
    formSteps[0].classList.add('active');
    document.getElementById('productForm').reset();
    updateButtonVisibility();
}

    function updateButtonVisibility() {
        prevBtn.style.display = currentStep === 0 ? 'none' : 'block';
        nextBtn.style.display = currentStep === formSteps.length - 1 ? 'none' : 'block';
        submitBtn.style.display = currentStep === formSteps.length - 1 ? 'block' : 'none';
    }

    // Next button click handler
    nextBtn.addEventListener('click', () => {
    if(currentStep < formSteps.length - 1) {
        formSteps[currentStep].classList.remove('active');
        currentStep++;
        formSteps[currentStep].classList.add('active');
        updateButtonVisibility();
    }
});
    // Previous button click handler
    prevBtn.addEventListener('click', () => {
    if(currentStep > 0) {
        formSteps[currentStep].classList.remove('active');
        currentStep--;
        formSteps[currentStep].classList.add('active');
        updateButtonVisibility();
    }
});
    // Form submit handler
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('add_product.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if(response.ok) {
                closeModal();
                location.reload();
            } else {
                throw new Error('Network response was not ok');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving the product');
        });
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target === productModal) {
            closeModal();
        }
    };

    // Close modal when clicking close button
    document.querySelector('.close').addEventListener('click', closeModal);

    // Handle Enter key press in form steps
    document.getElementById('productForm').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            if(currentStep < formSteps.length - 1) {
                nextBtn.click();
            }
        }
    });
</script>
</body>
</html>