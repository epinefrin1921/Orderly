<?php

include('../includes/DB.php');
session_start();

$id = $_SESSION['id'];


$query = oci_parse($conn, "select * from CLIENT where C_ID = ". $id);
oci_execute($query);
$row = oci_fetch_assoc($query);

$query2 = oci_parse($conn, "select *
                                   FROM orders
                                   where O_STATUS='pending' and O_CLIENT=". $id." order by O_ID desc");
oci_execute($query2);

$query4 = oci_parse($conn, "select *
                                   FROM orders
                                   where O_STATUS='active' and O_CLIENT=". $id." order by O_ID desc");
oci_execute($query4);

$query3 = oci_parse($conn, "select *
                                   FROM orders
                                   where O_STATUS!='active' and O_STATUS!='pending' and O_CLIENT=". $id." order by O_ID desc");
oci_execute($query3);



if (oci_num_rows($query) === 0) {
    header('Location: ../error.php');
}

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
            <h2>Welcome, <?= $row['C_FNAME']." ".$row['C_LNAME'] ?></h2>
            <p>Email: <?= $row['C_EMAIL'] ?></p>
            <p>Date of birth: <?= $row['C_DOB'] ?></p>
            <p><a href="edit_account.php">Edit my account</a></p>
        </div>
        <img src="../1529573631.png">
    </div>

<div id="first">
    <?php if($row2=oci_fetch_assoc($query2)){
        oci_execute($query2);
        ?>
        <h1 style="text-align: center"> Pending orders: </h1>
        <section class="wrap" id="s3" style="color: black; padding-top: 20px">
            <?php while($row2=oci_fetch_assoc($query2)):?>
                <div class="in-line" style="color: #89253e">
                    <p style="color: white">Order ID <?= $row2['O_ID']?></p>
                    <p style="color: white">Price: <?= number_format($row2['O_TOTAL_AMOUNT'],2)?></p>
                    <p><a href="../orders/single_order.php?id=<?= $row2['O_ID']?>">See this order</a></p>
                </div>
            <?php endwhile; ?>
        </section>
    <?php };?>

    <?php if($row4=oci_fetch_assoc($query4)){
        oci_execute($query4);
        ?>
        <h1 style="text-align: center"> Active orders: </h1>
        <section class="wrap" id="s3" style="color: black; padding-top: 20px">
            <?php while($row4=oci_fetch_assoc($query4)):?>
                <div class="in-line">
                    <p>Order ID <?= $row4['O_ID']?></p>
                    <p>Price: <?= number_format($row4['O_TOTAL_AMOUNT'],2)?></p>
                    <p><a href="../orders/single_order.php?id=<?= $row4['O_ID']?>">See this order</a></p>
                </div>
            <?php endwhile; ?>
        </section>
    <?php };?>

    <?php if($row3=oci_fetch_assoc($query3)){
        oci_execute($query3);
        $row3 = oci_fetch_assoc($query);
        ?>
        <h1 style="text-align: center"> Your order history: </h1>
        <section class="wrap" id="s3" style="color: black; padding-top: 20px">
            <?php while($row3=oci_fetch_assoc($query3)):?>
                <div class="in-line" >
                    <p>Order ID <?= $row3['O_ID']?></p>
                    <p>Price: <?= number_format($row3['O_TOTAL_AMOUNT'],2)?></p>
                    <p>Status: <?= $row3['O_STATUS']?></p>
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