<?php
// Include database connection
require 'db_connection.php';

// Check if the review ID is provided in the request
if (isset($_POST['review_id'])) {
    // Sanitize the input to prevent SQL injection
    $reviewId = intval($_POST['review_id']); // Cast the review ID to an integer

    // Prepare the SQL query to delete the review from the database
    $deleteQuery = "DELETE FROM reviews WHERE id = ?";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($deleteQuery)) {
        // Bind the parameter to the prepared statement
        $stmt->bind_param('i', $reviewId);

        // Execute the query
        if ($stmt->execute()) {
            // If the query was successful, send a success message back
            echo "Review deleted successfully.";
        } else {
            // If there was an error executing the query
            echo "Error deleting review: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // If the query preparation failed
        echo "Error preparing the query: " . $conn->error;
    }
} else {
    // If no review ID was provided
    echo "Review ID not provided.";
}

// Close the database connection
$conn->close();
?>
