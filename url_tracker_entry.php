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
  
   
    <?php 
    include('connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $country = $_POST['country'];
        $subcountry = str_replace("'","\'", $country);
        $url = $_POST['url_link'];
        $suburl = str_replace("'","\'", $url);
        $notes = $_POST['notes'];
        $subnotes = str_replace("'","\'", $notes);
        $lookup = $_POST['lookup_link'];
        $sublookup = str_replace("'","\'", $lookup);
        $profession = $_POST['profession'];
        $subprofession = str_replace("'","\'", $profession);
        $january = $_POST['january'];
        $february = $_POST['february'];
        $march = $_POST['march'];
        $april = $_POST['april'];
        $may = $_POST['may'];
        $june = $_POST['june'];
        $july = $_POST['july'];
        $august = $_POST['august'];
        $september = $_POST['september'];
        $october = $_POST['october'];
        $november = $_POST['november'];
        $december = $_POST['december'];

        $sql = "INSERT INTO web_tracker (country, url_link, lookup_link, notes, profession, january, february, march, april, may, june, july, august, september, october, november, december)
            VALUES ('$subcountry', '$suburl', '$sublookup', '$subnotes', '$subprofession', '$january', '$february', '$march', '$april', '$may', '$june', '$july', '$august', '$september', '$october', '$november', '$december')";
        
        if ($conn->query($sql) === TRUE) {
            echo '
    <div id="successMessage" class="success-message">
        <span class="close"></span>
        <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; New record created successfully!</p>
    </div>
    ';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }   
        }
        $conn->close();
    ?>

  
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
                    
                    <form name="form" action="url_tracker_entry.php" onsubmit="return isvalid()" method="POST">

                        <div class="form-group">
                            <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['country'])){echo htmlentities($_POST['country']) ; }?>"  name="country" id="">
                            <label><strong>COUNTRY</strong></label>
                        </div>

                        <div class="form-group">
                            <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['url_link'])){echo htmlentities($_POST['url_link']); }?>" name="url_link" id="">
                            <label><strong>URL</strong></label>
                        </div>

                        <div class="form-group">
                            <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['lookup_link'])){echo htmlentities($_POST['lookup_link']); }?>"name="lookup_link" id="">
                            <label>LICENSE LOOKUP</label>
                        </div>

                        <div class="form-group">
                            <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['notes'])){echo htmlentities($_POST['notes']); }?>" name="notes" id="">
                            <label><strong>NOTES</strong></label>
                        </div>
                        

                        <div class="form-group">
                            <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['profession'])){echo htmlentities($_POST['profession']); }?>" name="profession"id="">
                            <label>PROFESSION</label>
                        </div>
                
                        </div>
                        </div>

                        <!-- Second Column -->
                        <div class="col-md-4 ">
                            <div class="formm">

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="january" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['january']) && $_POST['january'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['january']) && $_POST['january'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['january']) && $_POST['january'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>JANUARY</label>
                            </div>

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="february" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['february']) && $_POST['february'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['february']) && $_POST['february'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['february']) && $_POST['february'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>FEBRUARY</label>
                            </div>

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="march" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['march']) && $_POST['march'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['march']) && $_POST['march'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['march']) && $_POST['march'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>MARCH</label>
                            </div>

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="april" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['april']) && $_POST['april'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['april']) && $_POST['april'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['april']) && $_POST['april'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>APRIL</label>
                            </div>

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="may" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['may']) && $_POST['may'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['may']) && $_POST['may'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['may']) && $_POST['may'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>MAY</label>
                            </div>

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="june" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['june']) && $_POST['june'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['june']) && $_POST['june'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['june']) && $_POST['june'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>JUNE</label>
                            </div>
                            
                            </div>
                            </div>

                        <!-- 3rd Column -->
                        <div class="col-md-4 ">
                            <div class="formm">
                        
                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="july" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['july']) && $_POST['july'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['july']) && $_POST['july'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['july']) && $_POST['july'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>JULY</label>
                            </div>

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="august" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['august']) && $_POST['august'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['august']) && $_POST['august'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['august']) && $_POST['august'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>AUGUST</label>
                            </div>

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="september" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['september']) && $_POST['september'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['september']) && $_POST['september'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['september']) && $_POST['september'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>SEPTEMBER</label>
                            </div>

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="october" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['october']) && $_POST['october'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['october']) && $_POST['october'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['october']) && $_POST['october'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>OCTOBER</label>
                            </div>

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="november" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['november']) && $_POST['november'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['november']) && $_POST['november'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['november']) && $_POST['november'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>NOVEMBER</label>
                            </div>

                            <div class="form-group">
                                <select class="mob form-control" oninput="checkValue(this)" name="december" id="">
                                    <option value="" disabled selected></option>
                                    <option value="Not Available" <?php if(isset($_POST['december']) && $_POST['december'] === 'Not Available') echo 'selected'; ?>>Not Available</option>
                                    <option value="None Reported" <?php if(isset($_POST['december']) && $_POST['december'] === 'None Reported') echo 'selected'; ?>>None Reported</option>
                                    <option value="Collected" <?php if(isset($_POST['december']) && $_POST['december'] === 'Collected') echo 'selected'; ?>>Collected</option>
                                </select>
                                <label>DECEMBER</label>
                            </div>
                            <a href="url_tracker.php" class="btn btn-outline-success " tabindex="-1" role="button" aria-disabled="true">URL TRACKER</a>
                            <button type="submit" class="btn btn-success">Submit Entry</button>

                            <a class="btn btn-danger" href="url_tracker.php" role="button">Clear Info</a>


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