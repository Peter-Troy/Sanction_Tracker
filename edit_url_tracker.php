
<?php
include('connection.php');

$error = isset($error) ? $error : '';
$notification = isset($notification) ? $notification : '';


// Check if the 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch data for the selected provider entry
    $query = "SELECT * FROM web_tracker WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $id = mysqli_fetch_assoc($result);

            if (isset($_POST['submit'])) {

                // Update the data in the database
                $Uquery = "UPDATE web_tracker SET
                    `country` = '" . mysqli_real_escape_string($conn, $_POST['country']) . "',
                    url_link = '" . mysqli_real_escape_string($conn, $_POST['url_link']) . "',
                    lookup_link = '" . mysqli_real_escape_string($conn, $_POST['lookup_link']) . "',
                    notes = '" . mysqli_real_escape_string($conn, $_POST['notes']) . "',
                    profession = '" . mysqli_real_escape_string($conn, $_POST['profession']) . "',
                    january = '" . mysqli_real_escape_string($conn, $_POST['january']) . "',
                    february = '" . mysqli_real_escape_string($conn, $_POST['february']) . "',
                    march = '" . mysqli_real_escape_string($conn, $_POST['march']) . "',
                    april = '" . mysqli_real_escape_string($conn, $_POST['april']) . "',
                    may = '" . mysqli_real_escape_string($conn, $_POST['may']) . "',
                    june = '" . mysqli_real_escape_string($conn, $_POST['june']) . "',
                    july = '" . mysqli_real_escape_string($conn, $_POST['july']) . "',
                    august = '" . mysqli_real_escape_string($conn, $_POST['august']) . "',
                    september = '" . mysqli_real_escape_string($conn, $_POST['september']) . "',
                    october = '" . mysqli_real_escape_string($conn, $_POST['october']) . "',
                    november = '" . mysqli_real_escape_string($conn, $_POST['november']) . "',
                    december = '" . mysqli_real_escape_string($conn, $_POST['december']) . "'
                    WHERE id = '" . mysqli_real_escape_string($conn, $id['id']) . "'";

                    if (mysqli_query($conn, $Uquery)) {
                        $notification = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Update was successful.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else {
                        $error = '<div class="text-warning" role="alert">Update Failed!</div>' . mysqli_error($conn);
                    }
                } elseif (isset($_POST['delete'])) {
                    // Delete the entry from the database
                    $Dquery = "DELETE FROM url_tracker WHERE id = '" . mysqli_real_escape_string($conn, $id['id']) . "'";
    
                    if (mysqli_query($conn, $Dquery)) {
                        $notification = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Entry deleted successfully.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        // Optionally, redirect to a different page after deletion
                        header("Location: url_tracker.php");
                        exit();
                    } else {
                        $error = '<div class="text-warning" role="alert">Deletion Failed!</div>' . mysqli_error($conn);
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
                    <input type="text" class="mob form-control"  id="" name="country" value="<?php echo $id['country']; ?>">
                        </div>

                        <div class="form-group">
                        <label for="url_link" class="form-label"style="color: #009688;" >url_link:</label>
                    <input type="text" class="mob form-control" id="url_link" name="url_link" value="<?php echo $id['url_link']; ?>">
                        </div>

                        <div class="form-group">
                        <label for="lookup_link" class="form-label"style="color: #009688;">lookup_link:</label>
                    <input type="text" class="mob form-control" id="lookup_link" name="lookup_link" value="<?php echo $id['lookup_link']; ?>">
                        </div>
                        

                        <div class="form-group">
                        <label for="notes" class="form-label"style="color: #009688;">notes:</label>
                    <input type="text" class="mob form-control" id="notes" name="notes" value="<?php echo $id['notes']; ?>">
                        </div>
                        
                        <div class="form-group">
                        <label for="profession" class="form-label"style="color: #009688;">profession:</label>
                    <input type="text" class="mob form-control" id="profession" name="profession" value="<?php echo $id['profession']; ?>">
                        </div>
                        </div>
                        </div>

                        <!-- Second Column -->
                        <div class="col-md-4 ">
                            <div class="formm">
                   
                            <div class="form-group">
                                <label for="january" class="form-label"style="color: #009688;">January:</label>
                                <select class="form-control" oninput="checkValue(this)" name="january" id="january">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" style="background-color: red;" <?php if(isset($_POST['january']) && $_POST['january'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['january'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" style="background-color: blue;" <?php if(isset($_POST['january']) && $_POST['january'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['january'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" style="background-color: green;" <?php if(isset($_POST['january']) && $_POST['january'] === 'Collected') echo 'selected'; ?> <?php echo ($id['january'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="february" class="form-label"style="color: #009688;">february:</label>
                                <select class="form-control" oninput="checkValue(this)" name="february" id="february">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['february']) && $_POST['february'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['february'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['february']) && $_POST['february'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['february'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['february']) && $_POST['february'] === 'Collected') echo 'selected'; ?> <?php echo ($id['february'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="march" class="form-label"style="color: #009688;">march:</label>
                                <select class="form-control" oninput="checkValue(this)" name="march" id="march">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['march']) && $_POST['march'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['march'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['march']) && $_POST['march'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['march'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['march']) && $_POST['march'] === 'Collected') echo 'selected'; ?> <?php echo ($id['march'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="april" class="form-label"style="color: #009688;">april:</label>
                                <select class="form-control" oninput="checkValue(this)" name="april" id="april">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['april']) && $_POST['april'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['april'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['april']) && $_POST['april'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['april'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['april']) && $_POST['april'] === 'Collected') echo 'selected'; ?> <?php echo ($id['april'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="may" class="form-label"style="color: #009688;">may:</label>
                                <select class="form-control" oninput="checkValue(this)" name="may" id="may">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['may']) && $_POST['may'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['may'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['may']) && $_POST['may'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['may'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['may']) && $_POST['may'] === 'Collected') echo 'selected'; ?> <?php echo ($id['may'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="june" class="form-label"style="color: #009688;">june:</label>
                                <select class="form-control" oninput="checkValue(this)" name="june" id="june">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['june']) && $_POST['june'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['june'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['june']) && $_POST['june'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['june'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['june']) && $_POST['june'] === 'Collected') echo 'selected'; ?> <?php echo ($id['june'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>

                            
                            </div>
                            </div>

                        <!-- Second Column -->
                        <div class="col-md-4 ">
                            <div class="formm">

                            <div class="form-group">
                                <label for="july" class="form-label"style="color: #009688;">july:</label>
                                <select class="form-control" oninput="checkValue(this)" name="july" id="july">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['july']) && $_POST['july'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['july'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['july']) && $_POST['july'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['july'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['july']) && $_POST['july'] === 'Collected') echo 'selected'; ?> <?php echo ($id['july'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <label for="august" class="form-label"style="color: #009688;">august:</label>
                                <select class="form-control" oninput="checkValue(this)" name="august" id="august">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['august']) && $_POST['august'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['august'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['august']) && $_POST['august'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['august'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['august']) && $_POST['august'] === 'Collected') echo 'selected'; ?> <?php echo ($id['august'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="september" class="form-label"style="color: #009688;">september:</label>
                                <select class="form-control" oninput="checkValue(this)" name="september" id="september">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['september']) && $_POST['september'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['september'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['september']) && $_POST['september'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['september'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['september']) && $_POST['september'] === 'Collected') echo 'selected'; ?> <?php echo ($id['september'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="october" class="form-label"style="color: #009688;">october:</label>
                                <select class="form-control" oninput="checkValue(this)" name="october" id="october">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['october']) && $_POST['october'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['october'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['october']) && $_POST['october'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['october'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['october']) && $_POST['october'] === 'Collected') echo 'selected'; ?> <?php echo ($id['october'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="november" class="form-label"style="color: #009688;">november:</label>
                                <select class="form-control" oninput="checkValue(this)" name="november" id="november">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['november']) && $_POST['november'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['november'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['november']) && $_POST['november'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['november'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['november']) && $_POST['november'] === 'Collected') echo 'selected'; ?> <?php echo ($id['november'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="december" class="form-label"style="color: #009688;">december:</label>
                                <select class="form-control" oninput="checkValue(this)" name="december" id="december">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['december']) && $_POST['december'] === 'Not Available') echo 'selected'; ?> <?php echo ($id['december'] === 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['december']) && $_POST['december'] === 'None Reported') echo 'selected'; ?> <?php echo ($id['december'] === 'None Reported') ? 'selected' : ''; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['december']) && $_POST['december'] === 'Collected') echo 'selected'; ?> <?php echo ($id['december'] === 'Collected') ? 'selected' : ''; ?>>Collected</option>
                                </select>
                            </div>
            
                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-success" href="url_tracker.php" role="button">See Updated Entry</a>
                <button type="button" onclick="deleteRecord(<?php echo $id['id']; ?>)" class="btn btn-danger">Delete</button>


                    </form>
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

    function deleteRecord(recordId) {
    var confirmation = prompt("Type 'delete' to confirm deletion:");
    if (confirmation && confirmation.toLowerCase() === 'delete') {
        // Redirect to PHP script that handles the deletion
        window.location.href = 'url_tracker.php?id=' + recordId;
    } else {
        alert("Deletion canceled.");
    }
}
</script>

