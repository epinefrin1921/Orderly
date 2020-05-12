<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Register Now</title>
    <link rel="stylesheet" href="RegStil.css">
</head>
<body>
<h1>Welcome to orderly</h1>
<form class="Login" action="insert.php" method="post">
    <h2>Register</h2>
    <div class="textbox">
        <input type="text" placeholder="Name" name="FName" value="">
    </div>
    <div class="textbox">
        <input type="text" placeholder="Surname" name="LName" value="">
    </div>
    <div class="textbox" id="date1">
        <input type="date" placeholder="Date of Birth" name="DOB" value="">
    </div>
    <div class="textbox">
        <input type="text" placeholder="E-mail" name="Email" value="">
    </div>
    <div class="textbox">
        <input type="password" placeholder="New Password" name="Password" value="">
    </div>
    <div class="textbox">
        <input type="password" placeholder="Confirm Password" name="ConfirmPassword" value="" >
    </div>
    <input class="butt" type="submit" name="" value="Submit" >
</form>


    <?php include 'footer.php'; ?>
    <?php
    $user='root';
    $pass='';
    $db='project';
    $db= new mysqli('localhost',$user,$pass,$db) or die("Unable to connect!");
    ?>
</body>
</html>
