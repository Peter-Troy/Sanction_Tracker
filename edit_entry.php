
<?php
include('connection.php');

$error = isset($error) ? $error : '';
$notification = isset($notification) ? $notification : '';


// Check if the 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    $providerId = $_GET['id'];

    // Fetch data for the selected provider entry
    $query = "SELECT * FROM provider_data WHERE id = $providerId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $providerDetails = mysqli_fetch_assoc($result);

            if (isset($_POST['submit'])) {

                // Update the data in the database
                $Uquery = "UPDATE provider_data SET
                    `country` = '" . mysqli_real_escape_string($conn, $_POST['country']) . "',
                    fname = '" . mysqli_real_escape_string($conn, $_POST['fname']) . "',
                    mname = '" . mysqli_real_escape_string($conn, $_POST['mname']) . "',
                    lname = '" . mysqli_real_escape_string($conn, $_POST['lname']) . "',
                    maturity_suffix = '" . mysqli_real_escape_string($conn, $_POST['maturity_suffix']) . "',
                    profession = '" . mysqli_real_escape_string($conn, $_POST['profession']) . "',
                    license_number = '" . mysqli_real_escape_string($conn, $_POST['license_number']) . "',
                    document_name = '" . mysqli_real_escape_string($conn, $_POST['document_name']) . "',
                    provider_address = '" . mysqli_real_escape_string($conn, $_POST['provider_address']) . "',
                    provider_sanction = '" . mysqli_real_escape_string($conn, $_POST['provider_sanction']) . "',
                    date_processed = '" . mysqli_real_escape_string($conn, $_POST['date_processed']) . "'
                    WHERE id = '$providerId'";

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
    <div class="body-content">
        <div class="row ">
            <!-- First Column -->
            <div class="col-md-4 ">
                <div class="formm">
                    
                <form method="post" action="">

                        <div class="form-group">
                        <label for="country" class="form-label" style="color: #009688;"><strong>Country *</strong></label>
                    <input type="text" class="mob form-control"  id="" name="country" value="<?php echo $providerDetails['country']; ?>">
                        </div>
                    
                        <div class="form-group">
                        <label for="fname" class="form-label" style="color: #009688;"><strong>First Name *</strong></label>
                    <input type="text" class="mob form-control" id="fname" name="fname" value="<?php echo $providerDetails['fname']; ?>">
                        </div>

                        <div class="form-group">
                        <label for="mname" class="form-label" style="color: #009688;">Middle Name</label>
                    <input type="text" class="mob form-control" id="mname" name="mname" value="<?php echo $providerDetails['mname']; ?>">
                        </div>
                        
                        <div class="form-group">
                        <label for="lname" class="form-label" style="color: #009688;"><strong>Last Name *</strong></label>
                    <input type="text" class="mob form-control" id="lname" name="lname" value="<?php echo $providerDetails['lname']; ?>">
                        </div>

                        <div class="form-group">
                        <label for="maturity_suffix" class="form-label" style="color: #009688;">Maturity Suffix</label>
                    <input type="text" class="mob form-control" id="maturity_suffix" name="maturity_suffix" value="<?php echo $providerDetails['maturity_suffix']; ?>">
                        </div>

                        <div class="form-group">
                        <label for="profession" class="form-label" style="color: #009688;"><strong>Profession *</strong></label>
                    <input type="text" class="mob form-control" id="profession" name="profession" value="<?php echo $providerDetails['profession']; ?>">
                        </div>
                        
                        <div class="form-group">
                        <label for="license_number" class="form-label" style="color: #009688;"><strong>License Number *</strong></label>
                    <input type="text" class="mob form-control" id="license_number" name="license_number" value="<?php echo $providerDetails['license_number']; ?>">
                        </div>

                        </div>
                        </div>

                        <!-- Second Column -->
                        <div class="col-md-4 ">
                            <div class="formm">
                

                            <div class="form-group">
                            <label for="document_name" class="form-label" style="color: #009688;"><strong>Document Name *</strong></label>
                    <input type="text" class="mob form-control" id="document_document_namedate" name="document_name" value="<?php echo $providerDetails['document_name']; ?>">
                            </div>

                            <div class="form-group">
                            <label for="provider_address" class="form-label" style="color: #009688;">Address </label>
                    <input type="text" class="mob form-control" id="provider_address" name="provider_address" value="<?php echo $providerDetails['provider_address']; ?>">
                            </div>
                            
                            </div>
                            </div>

                        <!-- 3rd Column -->
                        <div class="col-md-4 ">
                            <div class="formm">
                        
                            <div class="form-group">
                            <label for="birthdate" class="form-label" style="color: #009688;">Birthdate</label>
                    <input type="text" class="mob form-control" id="birthdate" name="birthdate" value="<?php echo $providerDetails['birthdate']; ?>">
                            </div>

                           
                            
                            <div class="form-group">
                            <label for="provider_sanction" class="form-label" style="color: #009688;"><strong>Sanction *</strong></label>
                    <input type="text" class="mob form-control" id="provider_sanction" name="provider_sanction" value="<?php echo $providerDetails['provider_sanction']; ?>">
                            </div>

                            <div class="form-group">
                            <label for="date_processed" class="form-label" style="color: #009688;"><strong>Date Processed yyyy-mm-dd *</strong></label>
                    <input type="text" class="mob form-control" id="date_processed" name="date_processed" value="<?php echo $providerDetails['date_processed']; ?>">
                            </div>

                            
                           
                                 <button type="submit" name="submit" class="btn btn-outline-primary">Update</button>
                        
                <a class="btn btn-success" href="entries_details.php?id=<?php echo $providerId?>" role="button">See Updated Details</a>
                    </form>
                    <?php if (isset($notification)) : ?>
                       
                            <?php echo $notification; ?>
                     
                    <?php endif; ?>

                    <?php if (isset($error)) : ?>
                       
                            <?php echo $error; ?>
                   
                    <?php endif; ?>
                </div>
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
        }, 4000); // Adjust the time according to the transition duration
    }

    // Automatically close the message after 2.5 seconds
    setTimeout(closeMessage, 2500);



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

<style>

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

</style>