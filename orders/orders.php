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
$title = 'All orders';
include('../includes/DB.php');
if(isset($_GET['type'])){
    $type=$_GET['type'];
    $query = oci_parse($conn, "select o.*, c.*
                                   FROM orders o, client c
                                   where o.O_CLIENT=c.C_ID and o.O_STATUS='{$type}' 
                                   order by o.O_ID desc");
    oci_execute($query);
}
else{
    $type=null;
    $query = oci_parse($conn, "select o.*, c.*
                                   FROM orders o, client c
                                   where o.O_CLIENT=c.C_ID order by o.O_ID desc");
    oci_execute($query);
}


?>
<!doctype html>
<html lang="en">
<head>
    <?php include('../includes/head.php') ?>
    <link rel="stylesheet" href="../styles/stil.css">
    <link rel="stylesheet" href="../styles/products.css">
    <link rel="stylesheet" href="../styles/myaccount.css">
</head>

<body>
<?php include('../includes/header.php') ?>
<div id="helping"></div>
<div id="first">
<?php if($row=oci_fetch_assoc($query)){
    oci_execute($query);
    ?>
    <h1 style="text-align: center; color: white"> All <?= $type ?> orders: </h1>
    <section class="wrap" id="s3" style="color: black; padding-top: 20px">
        <?php while($row=oci_fetch_assoc($query)):?>
            <div class="in-line" style="color: white">
                <p>Order ID <?= $row['O_ID']?></p>
                <p style="color:white">Status: <?= $row['O_STATUS']?></p>
                <p>Client <?= $row['C_FNAME']." ".$row['C_LNAME']?></p>
                <p>Price: <?= number_format($row['O_TOTAL_AMOUNT'],2)?>KM</p>
                <p><a href="../orders/single_order.php?id=<?= $row['O_ID']?>" style="text-decoration: none;">See this order</a></p>
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