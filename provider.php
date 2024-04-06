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
        <div class="sidebar-heading border-bottom">Providers</div>
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
                        <a href="provider_entry.php" class="btn btn-outline-success " tabindex="-1" role="button" aria-disabled="true">Add Provider</a>
                    </div>
                </div>
                </form>

            </nav>
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Provider </th>
                    <th scope="col">Provider's Description</th>
                    <th scope="col"> </th>
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
    $searchConditions[] = "CONCAT(sanction, ' ', sanction_code, ' ', sanction_description) LIKE '%$term%' OR sanction_code LIKE '%$term%' 
    OR sanction_description LIKE '%$term%'";
}

// Combine the conditions using OR
$searchConditions = implode(' OR ', $searchConditions);

// Construct the final SQL query
$sqlFilteredRecords = "SELECT * FROM providers 
                       WHERE $searchConditions
                       ORDER BY provider_name ASC";


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
    $sqlAllRecords = "SELECT * FROM providers ORDER BY provider_name ASC";
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
        echo "<td>" . $row["provider_name"] . "</td>";
        echo "<td>" . $row["provider_description"] . "</td>";
        echo "<td><a href='edit_provider.php?id=" . $row["id"] . "' ><img src='icons/edit.png' alt='Edit' class='edit-icon'></a></td>";
        
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
    echo "<li class='page-item'><a class='page-link' href='provider.php?page=" . ($page - 1) . "'>Previous</a></li>";
}

// Page links
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<li class='page-item'><a class='page-link' href='provider.php?page=$i'>$i</a></li> ";
}

// Next link
if ($page < $totalPages) {
    echo "<li class='page-item'><a class='page-link' href='provider.php?page=" . ($page + 1) . "'>Next</a></li>";
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

<script>                       

  // Close suggestions when clicking outside the input and suggestions
  document.addEventListener("click", function(event) {
    const suggestionsContainer = document.getElementById("suggestionList");
    if (event.target !== suggestionsContainer && event.target !== document.getElementById("description")) {
      suggestionsContainer.style.display = "none";
    }
  });


// Get the close button element
var closeBtn = document.querySelector(".close");

// Add a click event listener to the close button
closeBtn.addEventListener("click", function() {
  // Hide the success message when the close button is clicked
  document.querySelector(".success-message").style.display = "none";
});
 
function closeMessage() {
        var message = document.getElementById('successMessage');
        message.style.opacity = '0'; // Set opacity to 0 to trigger fade-out
        setTimeout(function() {
            message.style.display = 'none'; // Hide the message after the transition
        }, 1000); // Adjust the time according to the transition duration
    }

    // Automatically close the message after 2.5 seconds
    setTimeout(closeMessage, 2500);
</script>


<style>

.suggestions {
      display: none;
      position: absolute;
      border: 1px solid #ccc;
      max-height: 100px;
      overflow-y: auto;
    }
    .suggestion-item {
      padding: 8px;
      cursor: pointer;
    }

    .success-message {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 8px 12px;
    border-radius: 4px;
    margin-bottom: 10px;
    width: 2000px; /* Adjust the width as needed */
    text-align: left;
    position: fixed;
}

.close {
  float: left;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover {
  color: black;
}

