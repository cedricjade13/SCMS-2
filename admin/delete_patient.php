<?php
session_start(); // Start the session

// Include the database configuration file
include('../database/config.php'); // Make sure this path is correct

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Get the username from the session
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete statement
    $delete_sql = "DELETE FROM patients WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to view records after successful deletion
        header("Location: view_records.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "No ID provided.";
    exit();
}

// Close the database connection
$conn->close();
?>