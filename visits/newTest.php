<?php
session_start();
$title = 'New visit';
include ('../includes/db.php');
if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}
if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    $query = oci_parse($conn, "select * from CLIENT where C_ID = ".$id);
    oci_execute($query);
    $row = oci_fetch_assoc($query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles/stil.css">
    <link rel="stylesheet" href="../styles/RegStil.css">

    <?php include('../includes/head.php') ?>
</head>
<style>
    ::-webkit-scrollbar {
        display: none;
    }
</style>
<body>
<?php include '../includes/header.php';?>
<div id="helping"></div>

<div class="visitForm">
    <h1>Tested positive?</h1>
    <p class="visitDetails">If You tested positive, please let us know, so we can notify others to test themselves too! We won't share Your identity!</p>
    <form class="Login" action="submitTest.php" method="post" name="regform">
        <div class="textbox">
            <input type="text" placeholder="Name" name="fname" value="<?= isset($_SESSION['id'])? $row['C_FNAME'] : null ?>" >
        </div>
        <div class="textbox">
            <input type="text" placeholder="Surname" name="lname" value="<?= isset($_SESSION['id'])? $row['C_LNAME'] : null ?>" >
        </div>
        <div class="textbox">
            <input type="email" placeholder="E-mail" name="email" value="<?= isset($_SESSION['id'])? $row['C_EMAIL'] : null ?>" >
        </div>
        <div class="textbox">
            <input type="text" placeholder="Phone" name="phone" value="" >
        </div>
        <input class="butt" type="submit"  value="Submit" >
    </form>
</div>


<?php
include '../includes/footer.php'; ?>

</body>
</html>