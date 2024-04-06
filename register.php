<head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
</head>
<div id="form-container">
    <div id="form">
        <h1 id="heading">Register Form</h1><br>
        <form name="form" action="register.php" method="POST">
            <div id="input-container">
            <label>Username: </label><br>
            <input type="text" id="user" name="user" required><br><br>
            </div>
            <div id="input-container">
            <label>Password: </label><br>
            <input type="password" id="pass" name="pass" required><br><br>
            </div>
            <div id="input-container">
            <label>Retype Password: </label><br>
            <input type="password" id="cpass" name="cpass" required><br><br>
            <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='index.php'">Log in</button>
            <input type="submit" class="btn btn-primary btn-sm" id="btn" value="SignUp" name="submit">
            </div>
        </form>
    </div>
</div>


<?php
include("connection.php");

if (isset($_POST['submit'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $cpassword = $_POST['cpass'];

    $sql="select * from users where username='$username'";
    $result = mysqli_query($conn, $sql);
    $count_username = mysqli_num_rows(($result));

    
    if ($count_username == 0) {
        if ($password == $cpassword) {
            $sql = "INSERT INTO users (username, Password) VALUES ('$username', '$password')";
            $result = mysqli_query($conn, $sql);
    
            if ($result) {
                header("Location: welcome.php");
            }
        }
    }
    else{
        if($count_username > 0){
            echo'<script>
                window.location.href="index.php";
                alert("Username already exists");
                </script>';
        }
        if($count_password> 0){
            echo'<script>
                window.location.href="index.php";
                alert("Passowrd already exists");
                </script>';
        }
    }
}
?>


<style>

#input-container {
    text-align: center;
}

    #form-container {
    text-align: center;
}

#form {
    display: inline-block;
    text-align: left;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

</style>