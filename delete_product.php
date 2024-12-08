<?php
@include 'config.php'; // Make sure this points to your database config file
require_once "database.php"; // Include your database connection

// Check if the delete_id is passed in the request
if (isset($_GET['delete_id'])) {
    $product_id = $_GET['delete_id'];

    // Delete the product from the database
    $delete_query = "DELETE FROM items WHERE id = ?";
    $delete_stmt = mysqli_stmt_init($conn);
    
    if (mysqli_stmt_prepare($delete_stmt, $delete_query)) {
        mysqli_stmt_bind_param($delete_stmt, "i", $product_id);
        
        if (mysqli_stmt_execute($delete_stmt)) {
            // Send a success response
            echo json_encode(['status' => 'success', 'message' => 'Product deleted successfully']);
        } else {
            // Send an error response
            echo json_encode(['status' => 'error', 'message' => 'Error deleting product']);
        }
    } else {
        // Send an error response
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement']);
    }
} else {
    // Send an error response if delete_id is not provided
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided']);
}
