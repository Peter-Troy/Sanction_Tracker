
<?php
include('connection.php');

$error = isset($error) ? $error : '';
$notification = isset($notification) ? $notification : '';


// Check if the 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch data for the selected provider entry
    $query = "SELECT * FROM note WHERE id = $id";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $id = mysqli_fetch_assoc($result);

            if (isset($_POST['submit'])) {

                // Update the data in the database
                $Uquery = "UPDATE note SET

                    notes = '" . mysqli_real_escape_string($conn, $_POST['notes']) . "'
                    WHERE id = '" . mysqli_real_escape_string($conn, $id['id']) . "'";

                    if (mysqli_query($conn, $Uquery)) {
                        $notification = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Update was successful.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                        
                    } else {
                        $error = '<div class="text-warning" role="alert">Update Failed!</div>' . mysqli_error($conn);
                    }
                }
            } else {
                echo "<p>No details found for the selected provider.</p>";
            }
        } else {
            echo "<p>Error fetching details: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>No provider ID specified.</p>";
    }

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
            <a class="list-group-item list-group-item-action list-group-item p-3 custom-link" href="url_tracker_entry.php">URL tracker</a>
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
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item"><label id="dark-change"></label></li>   
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">
        <div class="body-content">
    <div class="container text-center"> <!-- Added container and text-center classes -->
            <div class="col-md-4 mx-auto"> <!-- Added mx-auto class -->
                <div class="formm">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="notes" class="form-label" style="font-weight: bold;">Edit Note:</label>
                            <input type="text" class="form-control" id="notes" name="notes" value="<?php echo $id['notes']; ?>">
                        </div>

                        <button type="submit" name="submit" class="btn btn-outline-primary">Update</button>
                        <a class="btn btn-success" href="notes.php" role="button">View Updated Entry</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                    </form>
                </div>
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

    function confirmDelete() {
        if (confirm("Are you sure you want to delete this record?")) {
            // If the user confirms, redirect to the delete page with the record ID
            window.location.href = "delete_note.php?id=<?php echo $id['id']; ?>";
        }
    }
</script>

