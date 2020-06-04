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

if($_POST) {
    if (checkRequiredField($_POST['start']) and checkRequiredField($_POST['end'])) {
        $start = date('Y-m-d', strtotime($_POST['start']));
        $end = date('Y-m-d', strtotime($_POST['end']));

        if ($start > $end) {
            header('Location: ../error.php');
            exit();
        }

        $query = oci_parse($conn, "select o.*, c.*, e.*
                                   FROM orders o, client c, EMPLOYEE e
                                   where e.E_ID=o.O_EMPLOYEE and o.O_CLIENT=c.C_ID and  O_DATE_RECEIVED>to_date('{$start}','YYYY-MM-DD') and O_DATE_RECEIVED<to_date('{$end}','YYYY-MM-DD') ");
        oci_execute($query);



        $start = date('d.m.Y', strtotime($start));
        $end = date('d.m.Y', strtotime($end));
    }
}
$title='Order statistics';

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

<div id="ord">
    <form action="orderstatistics.php" method="post">
        <label for="start" style="color:white;">Start date</label>
        <input type="date" id="start" name="start">
        <label for="end" style="color:white; margin-left:10px;">End date</label>
        <input type="date" id="end" name="end">
        <div id="o1"><input type="submit" style="width: 30%;"></div>
    </form>
</div>
<?php if($_POST):?>
<?php if($row=oci_fetch_assoc($query)){
oci_execute($query);
?>
<h1 style="text-align: center; color: white;"> All orders: </h1>
<section class="wrap" id="s3" style="color: white; padding-top: 20px">
    <?php while($row=oci_fetch_assoc($query)):?>
        <div class="in-line" style="color: white">
            <p>Order ID <?= $row['O_ID']?></p>
            <p>Client <?= $row['C_FNAME']." ".$row['C_LNAME']?></p>
            <p>Waiter <?= $row['E_FNAME']." ".$row['E_LNAME']?></p>
            <p>Price: <?= number_format($row['O_TOTAL_AMOUNT'],2)?>KM</p>
            <p><a href="../orders/single_order.php?id=<?= $row['O_ID']?>" style=" text-decoration: none;">See this order</a></p>
        </div>
    <?php endwhile; ?>
</section>
<?php };?>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>

</body>
</html>