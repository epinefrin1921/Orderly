<?php
include('../includes/DB.php');
session_start();
function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}
if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: ../index.php');
    exit();
}
$query = oci_parse($conn, "select distinct n.N_VISITID, v.* from NOTIFICATIONS n, VISITS v where n.N_VISITID=v.V_ID and v.V_CID=0");
oci_execute($query);
$title='Notifications';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles/stil.css">
    <link rel="stylesheet" href="../styles/myaccount.css">
    <link rel="stylesheet" href="../styles/orderstat.css">
    <?php include('../includes/head.php') ?>
</head>

<body>
<?php include '../includes/header.php';?>
<div id="helping"></div>


<h1 style="text-align: center; color: white;"> All unregistered people that were in contact with positive person: </h1>
<section class="wrap" id="s3" style="color: white; padding-top: 20px">
    <?php while($row=oci_fetch_assoc($query)):?>
        <div class="in-line" style="color: white">
            <p>Date <?= $row['V_DATE']?></p>
            <p>Client <?= $row['V_FNAME']." ".$row['V_LNAME']?></p>
            <p>Phone: <?= $row['V_PHONE'] ?></p>
            <p>Email: <?= $row['V_EMAIL'] ?></p>
        </div>
    <?php endwhile; ?>
    <p><a href="deleteNotifications.php">Delete all</a></p>
</section>

<?php include '../includes/footer.php'; ?>

</body>
</html>