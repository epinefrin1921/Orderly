<?php
session_start();
$title = 'New visit';
include ('../includes/db.php');
if(isset($_SESSION['id']) and $_SESSION['type']!=0){
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
    <h1>Register new visit to our restaurant!</h1>
    <p class="visitDetails">Due to current situation with COVID epidemic, we monitor all our guests and register each visit to restaurant. If You visit restaurant in the same time with someone that later tests positive to COVID, we will notify You!</p>
    <?php if(!isset($_SESSION['id'])): ?>
    <p class="visitDetails">You already have account? Simply login <a href="../validation/LogIn.php?newvisit=true"><em>here</em></a></p>
    <?php endif; ?>
    <form class="Login" action="submitVisit.php" method="post" name="regform">
        <div class="textbox">
            <input type="text" placeholder="Name" name="fname" value="<?php if($_SESSION['id']){echo $row["c_fname"];}; ?>" >
        </div>
        <div class="textbox">
            <input type="text" placeholder="Surname" name="lname" value="<?= isset($_SESSION['id'])? $row[1] : null ?>" >
        </div>
        <div class="textbox">
            <input type="email" placeholder="E-mail" name="email" value="<?= isset($_SESSION['id'])? $row[2] : null ?>" >
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
