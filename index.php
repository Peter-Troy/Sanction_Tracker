<?php 
    include("connection.php");
    include("login.php")
    ?>
    
<html>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="index_folder/style.css">
        <link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    </head>
    
    <body>
        
    <div id="form-container">
        <div id="form">
            <h1>Login Form</h1>
            <form name="form" action="login.php" onsubmit="return isvalid()" method="POST">
            <div id="input-container">
                <label>Username: </label><br>
                <input type="text" id="user" name="user"><br><br>
            </div>
            <div id="input-container">
                <label>Password: </label><br>
                <input type="password" id="pass" name="pass"><br><br>
            </div>
            <div id="input-container">
                <input type="submit" class="btn btn-primary btn-sm" id="btn" value="Login" name="submit">
                <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='register.php'">Register</button>
            </div>
            </form>
           
        </div>
    </div>
    </body>
    <script src="index_folder/app.js"></script>
</html>
