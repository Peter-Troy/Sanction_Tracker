<!DOCTYPE html>

<?php

require_once('connection.php');

$query = "SELECT * FROM web_tracker";
$result = mysqli_query($conn, $query);

// Check if the 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    $recordId = $_GET['id'];

    // Perform the deletion in your database
    $sql = "DELETE FROM web_tracker WHERE id = $recordId";

    if ($conn->query($sql) === TRUE) {
        // Deletion was successful
        echo "Record deleted successfully";
    } else {
        // Error deleting record
        echo "Error deleting record: " . $conn->error;
    }
}



// Fetch data from the database
$result_provider_data = mysqli_query($conn, "SELECT * FROM web_tracker");
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
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="notes.php">notes</a>



        </div>
    </div>
  
   
    <?php 
    include('connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data from the form
        $country = isset($_POST['country']) ? $_POST['country']: "";
        $url_link = isset($_POST['url_link']) ?$_POST['url_link']: "";
        $lookup_link = isset($_POST['lookup_link']) ?$_POST['lookup_link']: "";
        $notes = isset($_POST['notes']) ?$_POST['notes']: "";
        $profession = isset($_POST['profession']) ?$_POST['profession']: "";
        $january = isset($_POST['january']) ?$_POST['january']: "";
        $february = isset($_POST['february']) ?$_POST['february']: "";
        $march = isset($_POST['march']) ?$_POST['march']: "";
        $april = isset($_POST['april']) ?$_POST['april']: "";
        $may = isset($_POST['may']) ?$_POST['may']: "";
        $june = isset($_POST['june']) ?$_POST['june']: "";
        $july = isset($_POST['july']) ?$_POST['july']: "";
        $august = isset($_POST['august']) ?$_POST['august']: "";
        $september = isset($_POST['september']) ?$_POST['september']: "";
        $october = isset($_POST['october']) ?$_POST['october']: "";
        $november = isset($_POST['november']) ?$_POST['november']: "";
        $december = isset($_POST['december']) ?$_POST['december']: "";
  

        $sql = "INSERT INTO web_tracker (`country`, `url_link`, lookup_link, notes, profession, january, february,
                                            march, april, may, june, july, august, september, october, november, december)
                VALUES ('$country', '$url_link', '$lookup_link', '$notes', '$profession' ,'$january', '$february', 
                        '$march', '$april', '$may', '$june','$july', '$august', '$september', '$october', '$november', 
                        '$december')";
    
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
        <div class="container" >
        <nav class="navbar">
        <form class="form-inline" method="post" action="web_tracker.php">
            <div class="form-group row">
                <div class="col">
                    <input class="form-control" type="search" name="search" id="search" placeholder="Search:">
                </div>
 
                <div class="col-auto">
                    <button class="btn btn-outline-success" name="submit" type="submit">Search</button>
                    <a href="web_tracker.php" class="btn btn-outline-success" tabindex="-1" role="button" aria-disabled="true">Clear Filter</a>
                    <a href="url_tracker_entry.php" class="btn btn-outline-success" tabindex="-1" role="button" aria-disabled="true">Add url_link</a>
                </div>
            </div>
        </form>
                
            </nav>
            <div style="overflow-x: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">UPDATE</th>
                    <th scope="col">COUNTRY</th>
                    <th scope="col">WEBSITE</th>
                    <th scope="col">LOOKUP</th>
                    <th scope="col">NOTES</th>
                    <th scope="col">PROFESSION</th>
                    <th scope="col">JANUARY</th>
                    <th scope="col">FEBRUARY</th>
                    <th scope="col">MARCH</th>
                    <th scope="col">APRIL</th>
                    <th scope="col">MAY</th>
                    <th scope="col">JUNE</th>
                    <th scope="col">JULY</th>
                    <th scope="col">AUGUST</th>
                    <th scope="col">SEPTEMBER</th>
                    <th scope="col">OCTOBER</th>
                    <th scope="col">NOVEMBER</th>
                    <th scope="col">DECEMBER</th>
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
$searchConditions = array();


// Combine all search conditions using OR
$searchQuery = implode(' OR ', $searchConditions);

// Construct the final SQL query
$sql = "SELECT * FROM web_tracker WHERE $searchQuery";

foreach ($searchTerms as $term) {
    $term = trim($term); // Remove leading/trailing whitespaces

    // Add each term as a condition for fname, mname, and lname
    $searchConditions[] = "country LIKE '%$term%' OR profession LIKE '%$term%' OR notes LIKE '%$term%'";

}

// Combine the conditions using OR
$searchConditions = implode(' OR ', $searchConditions);

// Construct the final SQL query
$sqlFilteredRecords = "SELECT * FROM web_tracker 
                       WHERE $searchConditions
                       ORDER BY `country` ASC";


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
    $sqlAllRecords = "SELECT * FROM web_tracker ORDER BY `country` ASC";
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

// Get the current page number from the url_link parameter
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the records to be displayed
$offset = ($page - 1) * $recordsPerPage;

// Get a subset of records based on the offset and limit
$subsetRecords = array_slice($provider_records_all, $offset, $recordsPerPage);


// Display the records
if (count($subsetRecords) > 0) {
    foreach ($subsetRecords as $row) {
        echo '<tr>';
        echo '<td><a href="edit_url_tracker.php?id=' . $row["id"] . '"><img src="icons/web_tracker_edit.png" alt="Edit" class="edit-icon"></a></td>';
        echo '<td>' . $row["country"] . '</td>';
        echo '<td><a href="' . $row["url_link"] . '"" class="btn btn-success btn-sm">Web</a></td>';
        echo '<td><a href="' . $row["lookup_link"] . '"" class="btn btn-success btn-sm">Lookup</a></td>';
        echo '<td>' . $row["notes"] . '</td>';
        echo '<td>' . $row["profession"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["january"]) . ';">' . $row["january"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["february"]) . ';">' . $row["february"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["march"]) . ';">' . $row["march"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["april"]) . ';">' . $row["april"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["may"]) . ';">' . $row["may"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["june"]) . ';">' . $row["june"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["july"]) . ';">' . $row["july"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["august"]) . ';">' . $row["august"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["september"]) . ';">' . $row["september"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["october"]) . ';">' . $row["october"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["november"]) . ';">' . $row["november"] . '</td>';
        echo '<td style="background-color: ' . getColor($row["december"]) . ';">' . $row["december"] . '</td>';
        
        echo '</tr>';
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
    echo "<li class='page-item'><a class='page-link' href='web_tracker.php?page=" . ($page - 1) . "'>Previous</a></li>";
}

// Page links
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<li class='page-item'><a class='page-link' href='web_tracker.php?page=$i'>$i</a></li> ";
}

// Next link
if ($page < $totalPages) {
    echo "<li class='page-item'><a class='page-link' href='web_tracker.php?page=" . ($page + 1) . "'>Next</a></li>";
}

echo "</ul></nav>";

function getColor($value) {
    switch ($value) {
        case 'Not Available':
            return '#E78895'; // light red
        case 'None Reported':
            return '#A6CF98'; // light green
        case 'Collected':
            return '#89B9AD'; // light green
        default:
            return 'transparent'; // or any default color you prefer
    }

}
?>
                
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>



</div>
       
        <!-- Core theme JS-->
        <script src="js_sidebar/scripts.js"></script>
        <script src="js_form/entries_darkmode_script.js"></script>
        
</body>
</html>

<script>
function deleteRecord(recordId) {
    var confirmation = confirm("Are you sure you want to delete this record?");
    if (confirmation) {
        // Redirect to PHP script that handles the deletion
        window.location.href = 'entries.php?id=' + recordId;
    }
}
</script>
