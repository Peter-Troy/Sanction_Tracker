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

<div class="container">
<form action="" method="post">
            
            <div class="form-group">
                <label for="notes">Add Note:</label>
                <input type="text" name="notes" required>
            </div>
    
            <input type="submit" name="submit" value="Submit">
</form>
<a href="notes.php" class="back-link">Back to your notes</a>
</div>
</body>
</html>

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            margin-top: 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"],
        .back-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover,
        .back-link:hover {
            background-color: #0056b3;
        }
        .back-link {
            margin-top: 10px;
            background-color: #6c757d;
        }
    </style>