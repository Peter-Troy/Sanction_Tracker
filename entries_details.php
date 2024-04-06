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
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item"><label id="dark-change"></label></li>   
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">

                    <h2>Provider Details</h2>

            <?php
            require_once('connection.php');

            // Check if the 'id' parameter is set in the GET request
            if (isset($_GET['id'])) {
                $providerId = $_GET['id'];

                // Fetch data for the selected provider entry
                $query = "SELECT * FROM provider_data WHERE id = $providerId";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $providerDetails = mysqli_fetch_assoc($result);

                        // Display provider details
                        echo "<p><strong>State</strong> " . "<br>" . $providerDetails['country'] ."</p>";
                        echo "<p><strong>First Name </strong> "  . $providerDetails['fname'] . '<strong> Middle Name</strong> ' . $providerDetails['mname'] . '<strong> last Name</strong> ' . $providerDetails['lname'] . ' ' . $providerDetails['maturity_suffix'] . "</p>";
                        echo "<p><strong>Profession</strong> " . "<br>" . $providerDetails['profession'] . "</p>";
                        echo "<p><strong>License Number</strong> " . "<br>" . $providerDetails['license_number'] . "</p>";
                        echo "<p><strong>Document Name</strong> " . "<br>" . $providerDetails['document_name'] . "</p>";
                        echo "<p><strong>Address</strong> " .  $providerDetails['provider_address']."</p>";
                        echo "<p><strong>Birthdate</strong> " . "<br>" . $providerDetails['birthdate'] ."</p>";
                        echo "<p><strong>Description</strong> " . "<br>" . $providerDetails['provider_sanction'] ."</p>";
                        echo "<p><strong>Date Processed</strong> " . "<br>" . $providerDetails['date_processed'] ."</p>";
                        echo "<td><button class='btn btn-outline-danger' onclick='deleteRecord(" . $providerDetails["id"] . ")'> Delete</button></td>";

                        // Add more fields as needed

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

            <a href='edit_entry.php?id=<?php echo $providerDetails['id']; ?>' class='btn btn-primary'>Edit</a>

            <a href="entries.php" class="btn btn-primary">Back to Entries</a>
            
        </div>
</div>



</div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js_sidebar/scripts.js"></script>
        <script src="js_form/scripts.js"></script>
        <script src="entries_folder/app.js"></script>
        
</body>
</html>

<script>

    function isvalid(){
        
        var user = document.form.user.value;
        var pass = document.form.pass.value;
        if(user.length=="" && pass.length==""){
            alert(" Username and password field is empty!!!");
            return false;
        }
        else if(user.length==""){
            alert(" Username field is empty!!!");
            return false;
        }
        else if(pass.length==""){
            alert(" Password field is empty!!!");
            return true;
        }
        
    }

</script>

