<?php
include('../includes/DB.php');
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}

$title = 'Edit account'." ".$_SESSION['user_first_name'];
$id = $_SESSION['id'];


$query = oci_parse($conn, "select * from CLIENT where C_ID = ". $id);
oci_execute($query);
$row = oci_fetch_assoc($query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('../includes/head.php') ?>
    <link rel="stylesheet" href="../styles/RegStil.css">
</head>
<body>
<h1><a href="../index.php">Welcome to orderly</a></h1>
<?php
$today = date("Y-m-d");
?>
<form class="Login" action="update_user.php" method="post">
    <h2>Register</h2>
    <div class="textbox">
        <input type="text" placeholder="Name" name="fname" value="<?= $row['C_FNAME']?>" required>
    </div>
    <div class="textbox">
        <input type="text" placeholder="Surname" name="lname" value="<?= $row['C_LNAME']?>" required>
    </div>
    <div class="textbox">
        <input type="text" placeholder="E-mail" name="email" value="<?= $row['C_EMAIL']?>" required >
    </div>
    <div class="textbox">
        <input type="password" placeholder="New Password" name="password" value="">
    </div>
    <div class="textbox">
        <input type="password" placeholder="Confirm Password" name="confirmpassword" value="">
    </div>
    <input class="butt" type="submit" name="" value="Submit" >
</form>

</body>
</html>