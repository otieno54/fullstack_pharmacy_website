<?php
// Include the configuration file to connect to the database
include "config.php";

// Check if the 'id' parameter is passed
if (isset($_GET['id'])) {
    // Get the customer ID from the query string and sanitize it
    $customer_id = $_GET['id'];

    // Prepare a DELETE query to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM customer WHERE c_id = ?");
    
    // Bind the customer ID parameter to the query
    $stmt->bind_param("i", $customer_id); // 'i' denotes the integer type
    
    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the customer view page if successful
        header("Location: customer-view.php");
        exit(); // Make sure the script ends after the redirect
    } else {
        // If an error occurs, show a message
        echo "Error deleting record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // If the ID is not passed, show an error message
    echo "No customer ID provided.";
}

// Close the database connection
$conn->close();
?>
