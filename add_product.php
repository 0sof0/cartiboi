<?php
require 'db_connection.php';

header('Content-Type: application/json');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Fallback to regular POST data if empty
    if (empty($input)) {
        $input = $_POST;
    }

    // Validate required fields
    $requiredFields = ['name', 'category', 'gem_type', 'price', 'availability'];
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO products 
        (name, category, gem_type, price, discount_price, availability, size, description, image_path)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sssdsssss", 
        $input['name'],
        $input['category'],
        $input['gem_type'],
        $input['price'],
        $input['discount_price'] ?? null,
        $input['availability'],
        $input['size'] ?? '',
        $input['description'] ?? '',
        $input['image_path'] ?? ''
    );

    // Execute and respond
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Product added successfully',
            'product_id' => $stmt->insert_id
        ]);
    } else {
        throw new Exception('Database error: ' . $stmt->error);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
