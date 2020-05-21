<?php
session_start();
include('includes/DB.php');

if(!isset($_SESSION['id'])){
    header('Location: index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: index.php');
    exit();
}
$title = 'Register';

$query = oci_parse($conn, "select * from EMPLOYEE");
oci_execute($query);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" href="styles/RegStil.css">
</head>
<body>
<h1><a href="index.php">Welcome to orderly</a></h1>
<?php
$today = date("Y-m-d");
?>
<form class="Login" action="save_employee.php" method="post">
    <h2>Register</h2>
    <div class="textbox">
        <input type="text" placeholder="Name" name="fname" value="" required>
    </div>
    <div class="textbox">
        <input type="text" placeholder="Surname" name="lname" value="" required>
    </div>
    <div class="textbox" id="date1">
        <input type="date" placeholder="Date of Birth" name="DOB" value="" required min="1900-01-01" max="<?php echo $today?>">

    </div>
    <div class="textbox">
        <input type="text" placeholder="E-mail" name="email" value="" required >
    </div>
    <div class="textbox">
        <input type="password" placeholder="New Password" name="password" value="" required>
    </div>
    <div class="textbox">
        <input type="password" placeholder="Confirm Password" name="confirmpassword" value="" required >
    </div>
    <div class="textbox">
        <input type="number" placeholder="Salary" name="salary" required step="0.1" >
    </div>
    <div class="textbox">
        <input type="text" placeholder="Position" name="type" value="" required>
    </div>
    <div class="textbox">
        <p style="color: rgba(255,255,255,0.6)">Employee manager</p>
        <select name="manager" id="manager" required>
            <option value="" selected disabled hidden>Choose manager here</option>
            <?php while($row = oci_fetch_assoc($query)): ?>
            <option value="<?= $row['E_ID'] ?>"><?= $row['E_FNAME']." ".$row['E_LNAME'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <input class="butt" type="submit" name="" value="Submit" >
</form>

</body>
</html>