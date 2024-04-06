<!DOCTYPE html>

<?php

require_once('connection.php');

$query = "SELECT *, 
                 date_processed, DATE_FORMAT(date_processed, '%m/%d/%Y') AS formatted_date_processed
          FROM provider_data";
$result = mysqli_query($conn, $query);

// Check if the 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    $recordId = $_GET['id'];

    // Perform the deletion in your database
    $sql = "DELETE FROM provider_data WHERE id = $recordId";

    if ($conn->query($sql) === TRUE) {
        // Deletion was successful
        echo "Record deleted successfully";
    } else {
        // Error deleting record
        echo "Error deleting record: " . $conn->error;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all'])) {
    // Check if the button is clicked
    $confirmation = $_POST['confirmation'];
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    echo "Username: $username, Password: $password";

    //  authentication logic here 
    $sql_authenticate = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql_authenticate);
    // Bind parameters
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get result set
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
        
        if ($confirmation === "DELETE_ALL_RECORD") {
            // Perform the DELETE ALL operation
            $sql_delete_all = "DELETE FROM provider_data";
            
            if (mysqli_query($conn, $sql_delete_all)) {
                echo "All records deleted successfully";
            } else {
                echo "Error deleting records: " . mysqli_error($conn);
            }
        } else {
            echo "Deletion cancelled.";
        }
    } else {
        echo "Invalid username or password.";
    }
}

// Fetch data from the database
$result_provider_data = mysqli_query($conn, "SELECT * FROM provider_data");
$result_users = mysqli_query($conn, "SELECT * FROM users");
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="css_sidebar/styles.css" rel="stylesheet" />
    <link href="css_form/styles.css" rel="stylesheet" />
    <link href="css_form/toggle_button.css" rel="stylesheet" />
    <title>Sanction Tracker</title>

</head>

<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar-->
    <div class="border-end" id="sidebar-wrapper">
        <div class="sidebar-heading border-bottom">Sanction Tracker</div>
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="main.php">Home</a>
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="entries.php">Entries</a>
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="sanction.php">Sanctions</a>
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="provider.php">Providers </a>
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="url_tracker.php">URL tracker</a>
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="notes.php">Notes</a>
            <form method="post" action="entries.php"><br>
    <button class="btn btn-outline-danger btn-sm" style="display: block; margin: 0 auto;" type="button" id="deleteAllBtn" onclick="showConfirmation()">DELETE ALL RECORD</button>
    
    <div id="confirmationSection" style="display: none;">
        <label for="confirmation">Type "DELETE_ALL_RECORD" to confirm:</label><br><br>
        <input class="form-control" type="text" name="confirmation" placeholder = "DELETE_ALL_RECORD" required><br>
        
        <input class="form-control" type="text" name="username" placeholder = "enter your username" required><br>

        <input class="form-control" type="text" name="password" placeholder = "enter your password" required><br>
        <div class="text-center">
        <button type="submit" class="btn btn-danger btn-sm mx-auto" name="delete_all">Confirm Delete</button>
    </div>
    </div>

    
</form>

<script>
    function showConfirmation() {
        var isConfirmed = confirm("Are you sure you want to delete all records?");
        var confirmationSection = document.getElementById("confirmationSection");
        var deleteAllBtn = document.getElementById("deleteAllBtn");
        var confirmDeleteBtn = document.querySelector('[name="delete_all"]');

        // Show the confirmation section
        confirmationSection.style.display = "block";

        // Hide the "DELETE ALL" button
        deleteAllBtn.style.display = "none";

        // Show the "Confirm Delete" button
        confirmDeleteBtn.style.display = "inline-block";
    }
</script>

        </div>
    </div>
  
   
    <?php 
    include('connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data from the form
        $country = isset($_POST['country']) ? $_POST['country']: "";
        $fname = isset($_POST['fname']) ?$_POST['fname']: "";
        $mname = isset($_POST['mname']) ?$_POST['mname']: "";
        $lname = isset($_POST['lname']) ?$_POST['lname']: "";
        $maturity_suffix = isset($_POST['maturity_suffix']) ?$_POST['maturity_suffix']: "";

        $profession = isset($_POST['profession']) ?$_POST['profession']: "";
        $license_number = isset($_POST['license_number']) ?$_POST['license_number']: "";

        $document_name = isset($_POST['document_name']) ?$_POST['document_name']: "";
        $provider_address = isset($_POST['provider_address']) ?$_POST['provider_address']: "";
        
        $birthdate = isset($_POST['birthdate']) ?$_POST['birthdate']: "";
       
        $provider_sanction = isset($_POST['provider_sanction']) ?$_POST['provider_sanction']: "";
        $date_processed = isset($_POST['date_processed']) ?$_POST['date_processed']: "";

        $sql = "INSERT INTO provider_data (country, fname, mname, lname, maturity_suffix, , profession, license_number, , ,
                                            document_name, , provider_address, birthdate, provider_sanction, date_processed)
                VALUES ('$country', '$fname', '$mname', '$lname', '$maturity_suffix' ,'$profession' ,'$license_number' ,  '$document_name', '$provider_address',
                '$birthdate', '$provider_sanction', '$date_processed')";
    
        }
        
    ?>

  
    <!-- Page content wrapper-->
    <div id="page-content-wrapper">
        <!-- Top navigation-->
        <nav class="navbar navbar-expand-lg  custom-navbar">
            <div class="container-fluid">
            <button id="sidebarToggle">
                <img src="icons/menu.png" alt="Menu Icon" style="width: 40px; height: 40px; margin-right: 5px;"></button>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item"><label id="dark-change"></label></li>   
                    </ul>
                </div>
            </div>
            
        </nav>
        <!-- Page content-->
        <div class="container">
        <nav class="navbar">
    
                <form class="form-inline" method="post">
            <div class="form-group row">
                
        <div class="col">
            
            <input class="form-control" type="search" name="start_date" id="start_date" placeholder="Start Date: yyyy-mm-dd">
            
        </div>
        <div class="col">
            
            <input class="form-control" type="search" name="end_date" id="end_date" placeholder="End Date: yyyy-mm-dd">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-success " name="search_button" type="submit">Search</button>
            <a class="btn btn-outline-success " href="entries_search_by_date.php" role="button">Clear Filter</a>
           
        </div>
    </div>
</form>

            </nav>
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">COUNTRY</th>
                    <th scope="col">FULL NAME</th>
                    <th scope="col">PROFESSION</th>
                    <th scope="col">LICENSE #</th>
                    <th scope="col">SANCTION</th>
                    <th scope="col">PROC. DATE</th>
                    <th scope="col">FULL DETAILS</th>

                    </tr>
                </thead>
                <tbody>
                       

<?php

$provider_records_by_date = [];  // Initialize $provider_records_by_date outside the conditional blocks

if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Validate and sanitize user input
    if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $start_date) && preg_match("/^\d{4}-\d{2}-\d{2}$/", $end_date)) {
        // Specify your table name in the query
        $sqlFilter = "SELECT * FROM provider_data WHERE date_processed BETWEEN '$start_date' AND '$end_date' ORDER BY date_processed ASC ";
        $resultFilter = mysqli_query($conn, $sqlFilter);

        if (mysqli_num_rows($resultFilter) > 0) {
            while ($row = mysqli_fetch_assoc($resultFilter)) {
                $provider_records_by_date[] = $row;
            }
        }
    }
} else {
    // If no date filtering is applied, select all records
    $sqlAllRecords = "SELECT * FROM provider_data ORDER BY date_processed ASC";
    $resultAllRecords = mysqli_query($conn, $sqlAllRecords);

    if (mysqli_num_rows($resultAllRecords) > 0) {
        while ($row = mysqli_fetch_assoc($resultAllRecords)) {
            $provider_records_by_date[] = $row;
        }
    }
}

if (count($provider_records_by_date) > 0) {
    foreach ($provider_records_by_date as $row) {
       echo "<tr>";
       echo "<td>" . $row["country"] . "</td>";
       echo "<td>" . $row["fname"] . ' ' . $row["mname"] . '' . $row["lname"] . '' .$row["maturity_suffix"] . "</td>";
       echo "<td>" . $row["profession"] . "</td>";
       echo "<td>" . $row["license_number"] . "</td>";
       echo "<td>" . $row["provider_sanction"] . "</td>";
       echo "<td>" . $row["date_processed"] . "</td>";
       echo "<td style='text-align: center;'><a href='entries_details.php?id=" . $row["id"] . "' ><img src='icons/edit.png' alt='Edit' class='edit-icon'></a></td>";
       echo "</tr>";
    }
} else {
    echo "<tr><td colspan='14' class='no-records'>No records found.</td></tr>";
}

?>

                    
                
                </tbody>
            </table>
        </div>
    </div>
</div>



</div>
       
        <!-- Core theme JS-->
        <script src="js_sidebar/scripts.js"></script>
        <script src="js_form/entries_darkmode_script.js"></script>
        
</body>
</html>



<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_POST['search'])) {

    $search_term = isset($_POST['search_term']) ? $_POST['search_term'] : "";

    // Use prepared countryments to prevent SQL injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM provider_data WHERE fname LIKE ? OR mname LIKE ? OR lname LIKE ? OR profession LIKE ? OR license_number LIKE ? ORDER BY date_processed");

    // Bind parameters
    $search_term_with_wildcard = "%{$search_term}%";
    mysqli_stmt_bind_param($stmt, "sssss", $search_term_with_wildcard, $search_term_with_wildcard, $search_term_with_wildcard, $search_term_with_wildcard, $search_term_with_wildcard);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get result set
    $search_result = mysqli_stmt_get_result($stmt);

    // Check if the query was successful
    if ($search_result) {
        $count = mysqli_num_rows($search_result);

       
        // Display the filtered results
        while ($row = mysqli_fetch_assoc($search_result)) {
            // Your table row content
            echo '<tr>';
            echo '<td>' . $row['country'] . '</td>';
            echo '<td>' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . ' ' . $row['maturity_suffix'] . '</td>';
            echo '<td>' . $row['profession'] . '</td>';
            echo '<td>' . $row['license_number'] . '</td>';
            echo '<td>' . $row['action_date'] . '</td>';
            echo '<td>' . $row['provider_sanction'] . '</td>';
            echo '<td>' . $row['date_processed'] . '</td>';
            echo '</tr>';
            
        }
    } else {
        // Handle the case where the query fails
        echo "Query failed: " . mysqli_error($conn);
    }

    // Close the countryment
    mysqli_stmt_close($stmt);
}

?>

<script>
function deleteRecord(recordId) {
    var confirmation = confirm("Are you sure you want to delete this record?");
    if (confirmation) {
        // Redirect to PHP script that handles the deletion
        window.location.href = 'entries.php?id=' + recordId;
    }
}
</script>

