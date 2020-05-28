<?php
session_start();
include('../includes/DB.php');

$id=$_GET['id'];
$query = oci_parse($conn, "select o.*, m.*
                                   FROM  ORDER_LINE o, MENU_ITEMS m
                                   where m.MI_ID=o.OL_MENU  and  OL_ORDER=". $id);
oci_execute($query);

$query2 = oci_parse($conn, "select o.*, c.*, e.*
                                   FROM  ORDERS o, CLIENT c, EMPLOYEE e
                                   where  o.O_CLIENT=c.C_ID and e.E_ID=o.O_EMPLOYEE and O_ID=". $id);
oci_execute($query2);


$row2=oci_fetch_row($query2);
$status=$row2[3];


$query3 = oci_parse($conn, "select TO_CHAR(max(OH_TIME_CHANGED), 'YYYY-MM-DD HH24:MI:SS'), TO_CHAR(min(OH_TIME_CHANGED), 'YYYY-MM-DD HH24:MI:SS')
                                   from orders_history
                                    where OH_ORDER=". $id);
oci_execute($query3);

$row7=oci_fetch_row($query3);
$time1=date('d.m.Y H:i:s', strtotime($row7[0]));
$time2=date('d.m.Y H:i:s', strtotime($row7[1]));
$time3=abs(strtotime($time1)-strtotime($time2));

$minutes=$time3/60;

$hours=floor($minutes/60);

$minutes2=$minutes%60;

if(!isset($_SESSION['id']))
{
    header('Location: ../index.php');
    exit();
}
if($_SESSION['id']!=$row2[2] and $_SESSION['type']!=1)
{
    header('Location: ../index.php');
    exit();
}
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
<?php
    if($row2[3]=='finished')
    {?>
        <p>Time from placing the order to order being delivered to the costumer: <?= $hours!=0? $hours.' hours and': null ?> <?=$minutes2?> minutes</p>
   <?php }
?>
<p>Order status: <?= $status ?></p>
<?php if($_SESSION['type']==1 and $row2[3]!='deleted' and $row2[3]!='finished') {?>
    <form method="post" action="updateorder.php?ID=<?=$id?>">
        <label for="type">Choose a status of the order:</label>
        <select name="type" id="order_type">
            <option value="pending">Pending</option>
            <option value="active">Active</option>
            <option value="prepared">Prepared</option>
            <option value="finished">Finished</option>
        </select>
        <input type="submit">
    </form>
<?php } ?>
<p>Order time received: <?= $row2[5] ?></p>
<p>Waiter: <?= $row2[14]." ".$row2[15] ?></p>
<p>Order total: <?= $row2[2] ?>KM</p>
<p>Client: <?= $row2[7]." ".$row2[8] ?></p>
<?php if($_SESSION['type']==0):?>
    <p>Liked this order last time?</p>
    <a href="repeatorder.php?id=<?=$id?>" onclick="return confirm('Are you sure? You will be redirected to cart');">Order again</a>
<?php endif; ?>
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

<?php if($_SESSION['type']==0 and $status=='pending'):?>
   <a href="deleteorder.php?id=<?=$id?>" onclick="return confirm('Are you sure? Order will be deleted');">Delete order</a>
<?php endif; ?>

<?php include('../includes/footer.php') ?>


<?php $_SESSION['isUpdate']=null;?>
</body>
</html>