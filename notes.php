<?php 
    include('connection.php');
?>

<!DOCTYPE html>
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
    <div class="border-end" id="sidebar-wrapper" data-toggle="collapse" >
        <div class="sidebar-heading border-bottom">Sanction Tracker</div>
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="main.php">Home</a>
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="entries.php">Entries</a>
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="sanction.php">Sanctions</a>
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="provider.php">Providers </a>
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="url_tracker.php">URL tracker</a>
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="notes.php">Notes</a>
        </div>
    </div>
  
    <!-- Page content wrapper-->
    <div id="page-content-wrapper" >
        <!-- Top navigation-->
        <nav class="navbar navbar-expand-lg  custom-navbar">
            <div class="container-fluid">
            <button id="sidebarToggle" >
                <img src="icons/menu.png" alt="Menu Icon" style="width: 40px; height: 40px; margin-right: 5px;"></button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
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
                        <a href="add_notes.php" class="btn btn-success " tabindex="-1" role="button" aria-disabled="true">Add Note</a>
                    </div>
                    
                </div>
                </form>

            </nav>
            <table class="table">

                <thead>
                    <tr>
                    <th scope="col">NOTES</th>       
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
    $searchConditions[] = "CONCAT(notes) LIKE '%$term%'";
}

// Combine the conditions using OR
$searchConditions = implode(' OR ', $searchConditions);

// Construct the final SQL query
$sqlFilteredRecords = "SELECT * FROM note 
                       WHERE $searchConditions
                       ORDER BY notes ASC";


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
    $sqlAllRecords = "SELECT * FROM note ORDER BY notes ASC";
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
        echo "<td><a href='edit_note.php?id=" . $row["id"] . "'><img src='icons/edit.png' alt='Edit' class='edit-icon'></a>" . " &nbsp&nbsp&nbsp&nbsp&nbsp " . $row["notes"] . "</td>";
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
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js_sidebar/scripts.js"></script>
        <script src="js_form/scripts.js"></script>
        
</body>
</html>



