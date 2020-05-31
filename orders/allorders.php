<?php
include('../includes/DB.php');
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../../index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: ../../index.php');
    exit();
}

$title = 'Orders';
include('../includes/DB.php');

$query = oci_parse($conn, "select o.*, c.*
                                   FROM orders o, client c
                                   where o.O_CLIENT=c.C_ID and o.O_STATUS='pending' and rownum<30 order by o.O_ID desc");
oci_execute($query);

$query2 = oci_parse($conn, "select o.*, c.*
                                   FROM orders o, client c
                                   where o.O_CLIENT=c.C_ID and o.O_STATUS='active' and rownum<30 order by o.O_ID desc");
oci_execute($query2);

$query3 = oci_parse($conn, "select o.*, c.*
                                   FROM orders o, client c
                                   where o.O_CLIENT=c.C_ID and o.O_STATUS='prepared' and rownum<30 order by o.O_ID desc");
oci_execute($query3);

$query4 = oci_parse($conn, "select o.*, c.*
                                   FROM orders o, client c
                                   where o.O_CLIENT=c.C_ID and o.O_STATUS in ('deleted', 'finished') and rownum<10 order by o.O_ID desc");
oci_execute($query4);

?>
<!doctype html>
<html lang="en">
<head>
    <?php include('../includes/head.php') ?>
    <link rel="stylesheet" href="../styles/stil.css">
    <link rel="stylesheet" href="../styles/products.css">
    <link rel="stylesheet" href="../styles/myaccount.css">
    <link rel="stylesheet" href="../styles/allorders.css">
</head>

<body>
<?php include('../includes/header.php') ?>
<div id="helping"></div>

<div id="first">
<?php if($row=oci_fetch_assoc($query)){
    oci_execute($query);
    ?>
    <h1 style="text-align: center"> All pending orders:  </h1>
    <div class="w1"><a href="orders.php?type=pending">See more...</a></div>
    <section class="wrap" id="s3" style="color: white; padding-top: 20px">
        <?php while($row=oci_fetch_assoc($query)):?>
            <div class="in-line" style="color: white">
                <p>Order ID <?= $row['O_ID']?></p>
                <p>Client <?= $row['C_FNAME']." ".$row['C_LNAME']?></p>
                <p>Price: <?= number_format($row['O_TOTAL_AMOUNT'],2)?></p>
                <p><a href="../orders/single_order.php?id=<?= $row['O_ID']?>" style="text-decoration: none;">See this order</a></p>
            </div>
        <?php endwhile; ?>
    </section>
<?php };?>
<?php
if($row2=oci_fetch_assoc($query2)){
    oci_execute($query2);
    ?>
    <h1 style="text-align: center"> All active orders: </h1>
    <div class="w1"><a href="orders.php?type=active">See more...</a></div>
    <section class="wrap" id="s3" style="color: white; padding-top: 20px">
        <?php while($row2=oci_fetch_assoc($query2)):?>
            <div class="in-line" style="color: white">
                <p>Order ID <?= $row2['O_ID']?></p>
                <p>Client <?= $row2['C_FNAME']." ".$row2['C_LNAME']?></p>
                <p>Price: <?= number_format($row2['O_TOTAL_AMOUNT'],2)?></p>
                <p><a href="../orders/single_order.php?id=<?= $row2['O_ID']?>" style="text-decoration: none;">See this order</a></p>
            </div>
        <?php endwhile; ?>
    </section>
<?php };?>
<?php if($row3=oci_fetch_assoc($query3)){
    oci_execute($query3);
    ?>
    <h1 style="text-align: center"> All prepared orders: </h1>
    <div class="w1"><a href="orders.php?type=prepared">See more...</a></div>
    <section class="wrap" id="s3" style="color: white; padding-top: 20px">
        <?php while($row3=oci_fetch_assoc($query3)):?>
            <div class="in-line" style="color: white">
                <p>Order ID <?= $row3['O_ID']?></p>
                <p>Client <?= $row3['C_FNAME']." ".$row3['C_LNAME']?></p>
                <p>Price: <?= number_format($row3['O_TOTAL_AMOUNT'],2)?></p>
                <p><a href="../orders/single_order.php?id=<?= $row3['O_ID']?>" style="text-decoration: none;">See this order</a></p>
            </div>
        <?php endwhile; ?>
    </section>
<?php };?>
<?php if($row4=oci_fetch_assoc($query4)){
    oci_execute($query4);
    ?>
    <h1 style="text-align: center"> Orders history: </h1>
    <div class="w1"><a href="orders.php">See more...</a></div>
    <section class="wrap" id="s3" style="color: white; padding-top: 20px">
        <?php while($row4=oci_fetch_assoc($query4)):?>
            <div class="in-line" style="color: white">
                <p style="color:white">Order ID <?= $row4['O_ID']?></p>
                <p style="color:white">Client <?= $row4['C_FNAME']." ".$row4['C_LNAME']?></p>
                <p style="color:white">Price: <?= number_format($row4['O_TOTAL_AMOUNT'],2)?></p>
                <p style="color:white"><a href="../orders/single_order.php?id=<?= $row4['O_ID']?>" style="text-decoration: none">See this order</a></p>
            </div>
        <?php endwhile; ?>
    </section>
<?php };?>
</div>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        setInterval(timingLoad, 3000);
        function timingLoad() {
            $('#first').load(' #first', function() {
            });
        }
    });
</script>

<?php include('../includes/footer.php') ?>
</body>
</html>