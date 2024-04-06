<?php
include('connection.php');

// Check if the 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the record from the database
    $query = "DELETE FROM sanction_tracker WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Deletion successful, redirect to main page
        header("Location: sanction.php");
        exit;
    } else {
        // Error occurred during deletion
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // No record ID specified
    echo "No record ID specified.";
}
?>
