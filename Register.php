<?php

$title = 'Register';

?>

<!DOCTYPE html>
<html lang="en">
<head>
     <?php include('includes/head.php') ?>
    <link rel="stylesheet" href="styles/RegStil.css">
</head>
<body>
<h1><a href="index1.php">Welcome to orderly</a></h1>
<?php
$today = date("Y-m-d");
?>
<form class="Login" action="" method="post">
    <h2>Register</h2>
    <div class="textbox">
        <input type="text" placeholder="Name" name="FName" value="" required>
    </div>
    <div class="textbox">
        <input type="text" placeholder="Surname" name="LName" value="" required>
    </div>
    <div class="textbox" id="date1">
        <input type="date" placeholder="Date of Birth" name="DOB" value="" required min="1900-01-01" max="<?php echo $today?>">

    </div>
    <div class="textbox">
        <input type="text" placeholder="E-mail" name="Email" value="" required >
    </div>
    <div class="textbox">
        <input type="password" placeholder="New Password" name="Password" value="" required>
    </div>
    <div class="textbox">
        <input type="password" placeholder="Confirm Password" name="ConfirmPassword" value="" required >
    </div>
    <input class="butt" type="submit" name="" value="Submit" >
</form>

</body>
</html>