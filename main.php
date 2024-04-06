<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="css_sidebar/styles.css" rel="stylesheet" />
    <link href="css_form/styles.css" rel="stylesheet" />
    <link href="css_form/toggle_button.css" rel="stylesheet" />
    <link href="main_folder/style.css" rel="stylesheet" />

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

        // Function to check for duplicate records
        function isDuplicate($conn, $fname, $lname, $license_number, $provider_sanction) {
            $sql = "SELECT * FROM provider_data WHERE 
                    fname = '$fname' AND 
                    lname = '$lname' AND 
                    license_number = '$license_number' AND 
                    `provider_sanction` = '$provider_sanction'";
        
            $result = $conn->query($sql);
        
            // Check for query execution error
            if (!$result) {
                die("Error executing query: " . $conn->error);
            }
        
            // Check if the result is an object before accessing num_rows
            if (!is_object($result)) {
                die("Error: Query did not return a valid result object");
            }
        
            return ($result->num_rows > 0); // Return true if duplicate, false otherwise
        }

        // Fetch unique sanction values from the database
$sanctionsQuery = "SELECT DISTINCT * FROM sanction_tracker";
$result = $conn->query($sanctionsQuery);
$sanctions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sanctions[] = $row['sanction'];
    }
}

// Fetch unique sanction_code values from the database
$sanctionCodeQuery = "SELECT DISTINCT sanction FROM sanction_tracker";
$resultCode = $conn->query($sanctionCodeQuery);

$professionQuery = "SELECT DISTINCT provider_name FROM providers";
$resultProfession = $conn->query($professionQuery);

$sanctionCodes = [];
if ($resultCode->num_rows > 0) {
    while ($rowCode = $resultCode->fetch_assoc()) {
        $sanctionCodes[] = $rowCode['sanction'];
    }
}

$professionCodes = [];
if ($resultCode->num_rows > 0) {
    while ($rowCode = $resultProfession->fetch_assoc()) {
        $professionCodes[] = $rowCode['provider_name'];
    }
}

    function insertRecord($conn, $fname, $lname, $license_number, $provider_sanction) {
        $fname = $conn->real_escape_string($fname);
        $lname = $conn->real_escape_string($lname);
        $license_number = $conn->real_escape_string($license_number);
        $provider_sanction = $conn->real_escape_string($provider_sanction);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $country = $_POST['country'];
        $subcountry = str_replace("'","\'", $country);
        $fname = $_POST['fname'];
        $subfname = str_replace("'","\'", $fname);
        $mname = $_POST['mname'];
        $submname = str_replace("'","\'", $mname);
        $lname = $_POST['lname'];
        $sublname = str_replace("'","\'", $lname);
        $maturity_suffix = $_POST['maturity_suffix'];
        $submaturity_suffix = str_replace("'","\'", $maturity_suffix);
        $profession = $_POST['profession'];
        $subprofession = str_replace("'","\'", $profession);
        $license_number = $_POST['license_number'];
        $sublicense_number = str_replace("'","\'", $license_number);
        $birthdate = $_POST['birthdate'];
        $subbirthdate = str_replace("'","\'", $birthdate);
        $document_name = $_POST['document_name'];
        $subdocument_name = str_replace("'","\'", $document_name);
        $provider_address = $_POST['provider_address'];
        $subprovider_address = str_replace("'","\'", $provider_address);
        $provider_sanction = $_POST['provider_sanction'];
        $subdescription = str_replace("'","\'", $provider_sanction);
        $date_processed = $_POST['date_processed'];
        $subdate_processed = str_replace("'","\'", $date_processed);
      
        $result = isDuplicate($conn, $fname, $lname, $license_number, $provider_sanction);

        if ($result) {
            // Redirect to another PHP file
            header("Location: duplicate_record.php");
            exit(); // Ensure that further script execution stops after redirection
        } else {
            // Insert record
            insertRecord($conn, $fname, $lname, $license_number,  $provider_sanction);
        }

        $sql = "INSERT INTO provider_data (`country`, fname, mname, lname, maturity_suffix, profession, license_number, 
                                            document_name, provider_address,  birthdate, provider_sanction, date_processed)
                VALUES ('$subcountry', '$subfname', '$submname', '$sublname', '$submaturity_suffix' ,'$subprofession' ,'$sublicense_number', '$subdocument_name', '$subprovider_address',
                         '$subbirthdate',  '$subdescription', '$subdate_processed')";
        
        if ($conn->query($sql) === TRUE) {
            echo '
    <div id="successMessage" class="success-message">
        <span class="close"></span>
        <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; New record created successfully!</p>
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

                        <div class="col-md-1 ">
                         </div>
            <!-- First Column -->
            <div class="col-md-4 ">
                <div class="formm">
                    
                    <form name="form" action="main.php" onsubmit="return isvalid()" method="POST">

                        <div class="form-group">
                            <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['fname'])){echo htmlentities($_POST['fname']); }?>" name="fname" id="">
                            <label><strong>First Name</strong></label>
                        </div>


                        <div class="form-group">
                            <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['mname'])){echo htmlentities($_POST['mname']); }?>"name="mname" id="">
                            <label>Middle Name</label>
                        </div>
                        
                        <div class="form-group">
                            <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['lname'])){echo htmlentities($_POST['lname']); }?>" name="lname"id="">
                            <label><strong>Last Name *</strong></label>
                        </div>

                        <div class="form-group">
                            <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['maturity_suffix'])){echo htmlentities($_POST['maturity_suffix']); }?>" name="maturity_suffix" id="">
                            <label>Maturity Suffix</label>
                        </div>

                        <div class="form-group">
                                <input type="text" class="mob form-control" oninput="providerCheckValueOption(this); checkValue(this)" value="<?php if(isset($_POST['profession'])){echo htmlentities($_POST['profession']); }?>" name="profession" id="profession">
                                <label><strong>Profession*</strong></label>
                                <div class="suggestions" id="provider_suggestionList"></div>
                            </div>

                        <div class="form-group">
                                <input type="text" class="mob form-control" oninput="sanctionCheckValueOption(this); checkValue(this)" value="<?php if(isset($_POST['provider_sanction'])){echo htmlentities($_POST['provider_sanction']); }?>" name="provider_sanction" id="provider_sanction">
                                <label><strong>Sanction*</strong></label>
                                <div class="suggestions" id="sanction_suggestionList"></div>
                            </div>
  
                        </div>
                        </div>

                        <div class="col-md-2 ">
                         </div>

                        <!-- Second Column -->
                        <div class="col-md-4 ">
                            <div class="formm">

                             <div class="form-group">
                            <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['country'])){echo htmlentities($_POST['country']) ; }?>"  name="country" id="">
                            <label>Country</label>
                             </div>

                            <div class="form-group">
                                <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['license_number'])){echo htmlentities($_POST['license_number']); }?>" name="license_number" id="">
                                <label><strong>License Number *</strong></label>
                             </div>
                    

                            <div class="form-group">
                                <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['document_name'])){echo htmlentities($_POST['document_name']); }?>" name="document_name" id="">
                                <label><strong>Document Name *</strong></label>
                            </div>

                            <div class="form-group">
                                <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['provider_address'])){echo htmlentities($_POST['provider_address']); }?>" name="provider_address" id="">
                                <label><strong>Address *</strong></label>
                             </div>

                            <div class="form-group">
                                <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['birthdate'])){echo htmlentities($_POST['birthdate']); }?>" name="birthdate" id=""  title="Please use the YYYY/MM/DD format">
                                <label><strong>Birthdate</strong></label>
                            </div>

                            <div class="form-group">
                                <input type="text" class="mob form-control" oninput="checkValue(this)" value="<?php if(isset($_POST['date_processed'])){echo htmlentities($_POST['date_processed']); }?>" name="date_processed" id=""  title="Please use the YYYY/MM/DD format">
                                <label><strong>Date YYYY-MM-DD *</strong></label>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Submit Entry</button>

                            <a class="btn btn-danger" href="main.php" role="button">Clear Info</a>

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

const sanctionDescriptions = <?php echo json_encode($sanctions); ?>;

function sanctionCheckValueOption(inputElement) {
    const inputValue = inputElement.value.toLowerCase();
    const suggestionsContainer = document.getElementById("sanction_suggestionList");
    suggestionsContainer.innerHTML = "";

    const matchingDescriptions = <?php echo json_encode($sanctionCodes); ?>.filter(provider_sanction =>
        provider_sanction.toLowerCase().includes(inputValue)
    );

    if (matchingDescriptions.length > 0) {
        matchingDescriptions.forEach(provider_sanction => {
            const suggestionItem = document.createElement("div");
            suggestionItem.classList.add("suggestion-item");
            suggestionItem.textContent = provider_sanction;
            suggestionItem.addEventListener("click", () => {
                inputElement.value = provider_sanction;
                suggestionsContainer.style.display = "none";
            });
            suggestionsContainer.appendChild(suggestionItem);
        });

        suggestionsContainer.style.display = "block";
    } else {
        suggestionsContainer.style.display = "none";
    }
}

// Close suggestions when clicking outside the input and suggestions
document.addEventListener("click", function(event) {
    const suggestionsContainer = document.getElementById("sanction_suggestionList");
    if (event.target !== suggestionsContainer && event.target !== document.getElementById("provider_sanction")) {
      suggestionsContainer.style.display = "none";
    }
  });

  function providerCheckValueOption(inputElement) {
    const inputValue = inputElement.value.toLowerCase();
    const suggestionsContainer = document.getElementById("provider_suggestionList");
    suggestionsContainer.innerHTML = "";

    const matchingDescriptions = <?php echo json_encode($professionCodes); ?>.filter(profession =>
        profession.toLowerCase().includes(inputValue)
    );

    if (matchingDescriptions.length > 0) {
        matchingDescriptions.forEach(profession => {
            const suggestionItem = document.createElement("div");
            suggestionItem.classList.add("suggestion-item");
            suggestionItem.textContent = profession;
            suggestionItem.addEventListener("click", () => {
                inputElement.value = profession;
                suggestionsContainer.style.display = "none";
            });
            suggestionsContainer.appendChild(suggestionItem);
        });

        suggestionsContainer.style.display = "block";
    } else {
        suggestionsContainer.style.display = "none";
    }
}

// Close suggestions when clicking outside the input and suggestions
document.addEventListener("click", function(event) {
    const suggestionsContainer = document.getElementById("provider_suggestionList");
    if (event.target !== suggestionsContainer && event.target !== document.getElementById("profession")) {
      suggestionsContainer.style.display = "none";
    }
  });


function isvalid() {
    var fname = document.forms["form"]["fname"].value;
    var lname = document.forms["form"]["lname"].value;
    var profession = document.forms["form"]["profession"].value;
    var license = document.forms["form"]["license_number"].value;
    var DocumentName = document.forms["form"]["document_name"].value;
    var SanctionDescription = document.forms["form"]["provider_sanction"].value;
    var DateProcessed = document.forms["form"]["date_processed"].value;

    if ( fname === "" || lname === "" || profession == "" ||  license === "" || DocumentName == "" || SanctionDescription == "" || DateProcessed == "") {
        alert("Country, Firstname, Lastname, License Number, Sanction, and Date processed are required.");
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}

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
