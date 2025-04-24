<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h2>Add New Product</h2>
    <form action="add_product.php" method="POST">
        <label for="name">Product Name:</label><br>
        <input type="text" id="name" name="productNameame" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" step="0.01" required><br><br>

        <label for="discount_price">Discount Price:</label><br>
        <input type="number" id="discount_price" name="discount_price" step="0.01"><br><br>

        <label for="category">Category:</label><br>
        <select id="productCategory" name="productCategory" required>
            <option value="">--Select Category--</option>
            <option value="Ring">Ring</option>
            <option value="Earring">Earring</option>
            <option value="Necklace">Necklace</option>
            <option value="Bracelet">Bracelet</option>
        </select><br><br>

        <label for="productStone">Gem Type:</label><br>
        <select id="productStone" name="productStone" required>
            <option value="">--Select GemType--</option>
            <option value="Diamond">Diamond</option>
            <option value="Pearl">Pearl</option>
            <option value="Opal">Opal</option>
            <option value="Lapis">Lapis</option>
            <option value="Ruby">Ruby</option>
            <option value="Emerald">Emerald</option>
            <option value="Amethyst">Amethyst</option>
            <option value="Sapphire">Sapphire</option>
        </select><br><br>

        <label for="size">Size:</label><br>
        <input type="text" id="size" name="size"><br><br>

        <label for="productImage">Image URL or Path:</label><br>
        <input type="text" id="productImage" name="productImage"><br><br>

        <label for="availability">Availability:</label><br>
        <select id="availability" name="availability" required>
            <option value="in stock">In Stock</option>
            <option value="out of stock">Out of Stock</option>
        </select><br><br>

        <input type="submit" value="Add Product">
    </form>
</body>
</html>

