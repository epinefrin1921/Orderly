<?php
session_start();
include('../includes/DB.php');

if(!isset($_SESSION['id']) or $_SESSION['type']==1)
{
    header('Location: ../index.php');
    exit();
}
$id=$_GET['id'];

$query = oci_parse($conn, "select o.*, m.*
                                   FROM  ORDER_LINE o, MENU_ITEMS m
                                   where m.MI_ID=o.OL_MENU  and  OL_ORDER=". $id);
oci_execute($query);

$query2 = oci_parse($conn, "select *
                                   FROM  ORDERS
                                   where  O_ID=". $id);
oci_execute($query2);
$row2=oci_fetch_row($query2);

$title='Order '.$id;

?>
<!doctype html>
<html lang="en">
<head>
    <?php include('../includes/head.php') ?>
    <link rel="stylesheet" href="../styles/stil.css">
    <link rel="stylesheet" href="../styles/products.css">
</head>

<body>
<?php include('../includes/header.php') ?>

<div id="helping"></div>
<p>Order status: <?= $row2[3] ?></p>
<p>Order time received: <?= $row2[1] ?></p>
<h1 id="naslov3">Products in the order:</h1>

<section class="wrap" id="s3">
    <?php while($row=oci_fetch_assoc($query)):?>
        <div class="container">
            <div class="container2">
                <form method="post" action="addtocart.php?ID=<?php echo $row['MI_ID']; ?>">
                    <a href="../products/products/single_product.php?id=<?= $row['MI_ID'] ?>" class="info-more">
                        <img src="../images/<?=$row['MI_IMG']?>">
                        <p><?= $row['MI_NAME'] ?></p>
                        <p>Price: <?= number_format($row['MI_PRICE'],2)?>KM</p>
                        <p>Quantity: <?= number_format($row['OL_QUANTITY'],2)?></p>
                    </a>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</section>


<?php include('../includes/footer.php') ?>


<?php $_SESSION['isUpdate']=null;?>
</body>
</html>