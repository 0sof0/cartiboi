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
                        <tr id="product-<?php echo $row['id'];?>">
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['gem_type']); ?></td>
                            <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                            <td>$<?php echo htmlspecialchars($row['discount_price'] ?? 'No discount');?></td>
                            <td class="action-buttons">
                                <button class="edit-btn" onclick="editProduct(<?php echo $row['id']; ?>)">Edit</button>
                                <button class="delete-btn" onclick="deleteProduct(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div id="confirmDeleteModal" class="message">
                <p>Are you sure you want to delete this product?</p>
                <button id="confirmDeleteBtn"  style="background-color: red; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Yes, Delete</button>
                <button id="cancelDeleteBtn"  style="background-color: gray; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
            </div>
            <div class="message" id="messageDiv1"></div>
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
            <h2>Product Form</h2>
            <form id="productForm" action="add_product.php" method="POST">
                <input type="hidden" name="productId" id="productId">
                
                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input name="productName" type="text" id="productName" required>
                </div>
                
                <div class="form-group">
                    <label for="productCategory">Category</label>
                    <select name="productCategory" id="productCategory" required>
                        <option value="Ring">Ring</option>
                        <option value="Necklace">Necklace</option>
                        <option value="Earring">Earring</option>
                        <option value="Bracelet">Bracelet</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="productStone">Stone Type</label>
                    <select name="productStone" id="productStone" required>
                        <option value="Diamond">Diamond</option>
                        <option value="Emerald">Emerald</option>
                        <option value="Ruby">Ruby</option>
                        <option value="Sapphire">Sapphire</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="productPrice">Price</label>
                    <input name="price" type="number" id="productPrice" required>
                </div>
                
                <div class="form-group">
                    <label for="discount_price">Discount Price</label>
                    <input name="discount_price" type="number" id="discount_price">
                </div>
                
                <div class="form-group">
                    <label for="productImage">Image URL</label>
                    <input name="productImage" type="text" id="productImage" required>
                </div>
                
                <div class="form-group">
                    <label for="size">Size</label>
                    <input name="size" type="text" id="size">
                </div>
                
                <div class="form-group">
                    <label for="availability">Availability</label>
                    <select name="availability" id="availability">
                        <option value="In Stock">In Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" required></textarea>
                </div>

                <button type="submit" class="submit-btn" id="save-btn" value="<?php ?>">Save Product</button>
            </form>
            <div class="message" id="messageDiv"></div>
            


        </div>
    </div>

    <script>
        function showProductForm(product = null) {
            const modal = document.getElementById('productModal');
            if(product) {
                document.getElementById('productId').value = product.id;
                document.getElementById('productName').value = product.name;
                document.getElementById('productCategory').value = product.category;
                document.getElementById('productStone').value = product.stone;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('productImage').value = product.image;
            }
            modal.style.display = 'flex';
        }
        
        function editProduct(productId) {
            
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_product.php?id=' + productId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var product = JSON.parse(xhr.responseText);
                    // Populate form with product data
                    document.getElementById('productId').value = product.id;
                    document.getElementById('productName').value = product.name;
                    document.getElementById('productCategory').value = product.category;
                    document.getElementById('productStone').value = product.stone;
                    document.getElementById('productPrice').value = product.price;
                    document.getElementById('productImage').value = product.image;

                    // Set the operation to "edit"
                    document.getElementById('operation').value = 'edit';

                    // Show the modal
                    document.getElementById('productModal').style.display = 'flex';
                }
            };
            xhr.send();
        }



        
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
        function renderFeedback() {
            const tbody = document.getElementById('feedbackTable');
            tbody.innerHTML = feedback.map(item => `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.email}</td>
                    <td>${item.subject}</td>
                    <td>${item.message}</td>
                    <td>${new Date(item.date).toLocaleDateString()}</td>
                </tr>
            `).join('');
        }

        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
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
        
    </script>
</body>
</html>