<?php

include('../includes/DB.php');
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: ../index.php');
    exit();
}

$id = $_SESSION['id'];

$query = oci_parse($conn, "select * from EMPLOYEE where E_ID = ". $id);
oci_execute($query);
$row = oci_fetch_assoc($query);

$query2 = oci_parse($conn, "select o.*, c.*
                                   FROM orders o, client c
                                   where o.O_CLIENT=c.C_ID and o.O_STATUS in ('active', 'pending', 'ready') and O_EMPLOYEE=". $id);
oci_execute($query2);

$query3 = oci_parse($conn, "select o.*, c.*
                                   FROM orders o, client c
                                   where o.O_CLIENT=c.C_ID and o.O_STATUS in ('deleted', 'finished') and O_EMPLOYEE=". $id);
oci_execute($query3);

$title = $_SESSION['user_first_name']." ".$_SESSION['user_last_name'];
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('../includes/head.php') ?>
    <link rel="stylesheet" href="../styles/productsingle.css">
    <link rel="stylesheet" href="../styles/stil.css">
    <link rel="stylesheet" href="../styles/myaccount.css">

</head>

<body>
<?php include('../includes/header.php') ?>
<main class="wrap">

    <div class="prikaz">
        <div class="info">
            <h2>Welcome, <?= $row['E_FNAME']." ".$row['E_LNAME'] ?></h2>
            <p>Email: <?= $row['E_EMAIL'] ?></p>
            <p>Date of birth: <?= $row['E_DOB'] ?></p>
            <p><a href="edit_account.php">Edit my account</a></p>
            <?php if($row['E_TYPE']=='admin'): ?>
            <a href="registerEmployee.php">Register new employee</a>
                <a href="finance.php">Show finance</a>
                <a href="employeestatistics.php">Employee stats</a>
                <a href="orderstatistics.php">Order stats</a>
            <?php endif; ?>
        </div>
        <img src="../1529573631.png">
    </div>
    <div id="first">
    <?php if($row2=oci_fetch_assoc($query2)){
        oci_execute($query2);
        ?>
        <h1 style="text-align: center"> My active orders: </h1>
        <section class="wrap" id="s3" style="color: black; padding-top: 20px">
            <?php while($row2=oci_fetch_assoc($query2)):?>
                <div class="in-line" style="color: white">
                    <p>Order ID <?= $row2['O_ID']?></p>
                    <p>Client <?= $row2['C_FNAME']." ".$row2['C_LNAME']?></p>
                    <p>Price: <?= number_format($row2['O_TOTAL_AMOUNT'],2)?>KM</p>
                    <p><a href="../orders/single_order.php?id=<?= $row2['O_ID']?>">See this order</a></p>
                </div>
            <?php endwhile; ?>
        </section>
    <?php };?>

    <?php if($row3=oci_fetch_assoc($query3)){
        oci_execute($query3);
        ?>
        <h1 style="text-align: center"> My order history: </h1>
        <section class="wrap" id="s3" style="color: white; padding-top: 20px">
            <?php while($row3=oci_fetch_assoc($query3)):?>
                <div class="in-line" style="color: white">
                    <p>Order ID <?= $row3['O_ID']?></p>
                    <p>Client <?= $row3['C_FNAME']." ".$row3['C_LNAME']?></p>
                    <p>Price: <?= number_format($row3['O_TOTAL_AMOUNT'],2)?>KM</p>
                    <p><a href="../orders/single_order.php?id=<?= $row3['O_ID']?>">See this order</a></p>
                </div>
            <?php endwhile; ?>
        </section>
    <?php };?>
    </div>
</main>

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setInterval(timingLoad, 5000);
        function timingLoad() {
            $('#first').load(' #first', function() {
            });
        }
    });
</script>
<?php include('../includes/footer.php') ?>
</body>
</html>