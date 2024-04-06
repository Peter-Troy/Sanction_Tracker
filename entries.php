<!DOCTYPE html>
<?php

require_once('connection.php');

$query = "SELECT *, 
                 date_processed, DATE_FORMAT(date_processed, ' m/ d/ Y') AS formatted_date_processed
          FROM provider_data";
$result = mysqli_query($conn, $query);

// Check if the 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    $recordId = $_GET['id'];

    // Perform the deletion in your database
    $sql = "DELETE FROM provider_data WHERE id = $recordId";

    if ($conn->query($sql) === TRUE) {
        // Deletion was successful
        
        echo '<div id="successMessage" class="success-message">
        <span class="close"></span>
        <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Record Deleted successfully!</p>
    </div>';
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
    <link href="entries_folder/style.css" rel="stylesheet" />
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

        $sql = "INSERT INTO provider_data (`country`, fname, mname, lname, maturity_suffix, profession, license_number,
                                            document_name, provider_address, birthdate, `provider_sanction`, date_processed)
                VALUES ('$country', '$fname', '$mname', '$lname', '$maturity_suffix' ,'$profession' ,'$license_number', '$document_name', '$provider_address', 
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
            </div>
            
        </nav>
        <!-- Page content-->
        <div class="container">
        <nav class="navbar">
                <form class="form-inline" method="post" action="entries.php">
                <div class="form-group row">
                    <div class="col">
                        <input class="form-control" type="search" name="search" id="search" placeholder="Search:">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-success " name="submit" type="submit">Search</button>
                        <a href="entries.php" class="btn btn-outline-success " tabindex="-1" role="button" aria-disabled="true">Clear Filter</a>
                    </div>
                </div>
                </form>
                
                <form class="form-inline" method="post">
                    <div class="form-group row">
                        <div class="col-auto">
                            <a href="convert_to_excel_by_date.php" class="btn btn-outline-success btn-sm" tabindex="-1" role="button" aria-disabled="true">Generate to Excel by Date</a>  
                        </div>

                    </div>
                </form> 

                <form class="form-inline" method="post">
                    <div class="form-group row">
                        <div class="col-auto">
                            <a href="entries_search_by_date.php" class="btn btn-outline-success btn-sm" tabindex="-1" role="button" aria-disabled="true">Search by Date processed</a>  
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
                    <th scope="col">DETAILS</th>
                    
                    </tr>
                </thead>
                <tbody>
                       

<?php

$provider_records_all = [];

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $search = $_POST['search'];
    $search = mysqli_real_escape_string($conn, $search);

    // Assuming $search is a comma-separated list of terms
$searchTerms = explode(' ', $search);
$searchConditions = [];

foreach ($searchTerms as $term) {
    $term = trim($term); // Remove leading/trailing whitespaces

    // Add each term as a condition for fname, mname, and lname
    $searchConditions[] = "CONCAT(fname, ' ', mname, ' ', lname, '', maturity_suffix) LIKE '%$term%' OR country LIKE '%$term%' 
    OR profession LIKE '%$term%' OR license_number LIKE '%$term%' OR provider_sanction LIKE '%$term%'";
}

// Combine the conditions using OR
$searchConditions = implode(' OR ', $searchConditions);

// Construct the final SQL query
$sqlFilteredRecords = "SELECT * FROM provider_data 
                       WHERE $searchConditions
                       ORDER BY date_processed ASC";


    $resultFilteredRecords = mysqli_query($conn, $sqlFilteredRecords);

    if ($resultFilteredRecords) {
        // Check if there are any records
        if (mysqli_num_rows($resultFilteredRecords) > 0) {
            while ($row = mysqli_fetch_assoc($resultFilteredRecords)) {
                $provider_records_all[] = $row;
            }
        }
    } 
} else {
    // If no search criteria is applied, select all records
    $sqlAllRecords = "SELECT * FROM provider_data ORDER BY date_processed ASC";
    $resultAllRecords = mysqli_query($conn, $sqlAllRecords);

    if ($resultAllRecords) {
        // Check if there are any records
        if (mysqli_num_rows($resultAllRecords) > 0) {
            while ($row = mysqli_fetch_assoc($resultAllRecords)) {
                $provider_records_all[] = $row;
            }
        }
    } 
}



// Number of records to display per page
$recordsPerPage = 20;

// Get the current page number from the URL parameter
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the records to be displayed
$offset = ($page - 1) * $recordsPerPage;

// Get a subset of records based on the offset and limit
$subsetRecords = array_slice($provider_records_all, $offset, $recordsPerPage);


// Display the records
if (count($subsetRecords) > 0) {
    foreach ($subsetRecords as $row) {
        echo "<tr>";
        echo "<td>" . $row["country"] . "</td>";
        echo "<td>" . $row["fname"] . ' ' . $row["mname"] . ' ' . $row["lname"] . ' ' .$row["maturity_suffix"] ."</td>";
        echo "<td>" . $row["profession"] . "</td>";
        echo "<td>" . $row["license_number"] . "</td>";

        echo "<td>" . $row["provider_sanction"] . "</td>";

        echo "<td>" . $row["date_processed"] . "</td>";
        echo "<td style='text-align: center;'><a href='entries_details.php?id=" . $row["id"] . "' ><img src='icons/edit.png' alt='Edit' class='edit-icon'></a></td>";
        
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' class='no-records'>No records found.</td></tr>";
}


// Your existing code for pagination
$totalPages = ceil(count($provider_records_all) / $recordsPerPage);

// Display pagination links
echo "<nav aria-label='Page navigation example'><ul class='pagination'>";

// Previous link
if ($page > 1) {
    echo "<li class='page-item'><a class='page-link' href='entries.php?page=" . ($page - 1) . "'>Previous</a></li>";
}

// Page links
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<li class='page-item'><a class='page-link' href='entries.php?page=$i'>$i</a></li> ";
}

// Next link
if ($page < $totalPages) {
    echo "<li class='page-item'><a class='page-link' href='entries.php?page=" . ($page + 1) . "'>Next</a></li>";
}

echo "</ul></nav>";


?>

                    
                
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
       
        <!-- Core theme JS-->
        <script src="js_sidebar/scripts.js"></script>
        <script src="entries_folder/app.js"></script>
        <script src="js_form/entries_darkmode_script.js"></script>

</body>
</html>

