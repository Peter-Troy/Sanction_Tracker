<?php
include('connection.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Prepare an SQL statement
    $stmt = $conn->prepare("INSERT INTO note (notes) VALUES (:notes)");

    // Bind parameters
    $stmt->bindParam(':notes', $_POST['notes']);

    // Execute the statement
    try {
        $stmt->execute();
        echo "Note added successfully";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanction Tracker Form</title>
</head>
<body>

<form method="post" action="">
    <label for="notes">Add Note:</label>
    <input type="text" name="notes" required>


    <input type="submit" name="submit" value="Submit">
    <a href="notes.php">Back to Notes</a>

</form>

</body>
</html>
