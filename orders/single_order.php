<?php
session_start();
include('../includes/DB.php');

$id=$_GET['id'];
$query = oci_parse($conn, "select o.*, m.*
                                   FROM  ORDER_LINE o, MENU_ITEMS m
                                   where m.MI_ID=o.OL_MENU  and  OL_ORDER=". $id);
oci_execute($query);

$query2 = oci_parse($conn, "select o.*, c.*, e.*, to_char(o.O_DATE_RECEIVED, 'HH24:MI:SS DD-MM-YYYY')
                                   FROM  ORDERS o, CLIENT c, EMPLOYEE e
                                   where  o.O_CLIENT=c.C_ID and e.E_ID=o.O_EMPLOYEE and O_ID=". $id);
oci_execute($query2);


$row2=oci_fetch_row($query2);
$time=$row2[count($row2)-1];
$status=$row2[3];
$eid=$row2[14];
$cid=$row2[6];

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



$query4 = oci_parse($conn, "select * from EMPLOYEE where E_TYPE='waiter'");

if(!isset($_SESSION['id']))
{
    header('Location: ../index.php');
    exit();
}

if($_SESSION['type']!=1 and $_SESSION['id']!=$cid){
    header('Location: ../error.php');
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
    <link rel="stylesheet" href="../styles/single_order.css"
</head>

<body>
<?php include('../includes/header.php') ?>
<div id="helping"></div>
<?php
if (isset($_SESSION['order_placed']) and $_SESSION['order_placed']):?>
    <p class="up" id="nestat">Order has been placed</p>
<?php endif;?>
<?php if($_SESSION['type']==1 and $row2[3]!='canceled' and $row2[3]!='finished') {?>
    <form method="post" action="updateorder.php?ID=<?=$id?>">
        <div id="label"><label for="type">Choose a status of the order:</label>
            <select name="type" class="order_type">
                <option value="pending">Pending</option>
                <option value="active">Active</option>
                <option value="prepared">Prepared</option>
                <option value="finished">Finished</option>
                <option value="canceled">Canceled</option>
            </select></div>
        <div class="sub"><input type="submit"></div>
    </form>
    <form action="changewaiter.php?ID=<?=$id?>" method="post">
        <div class="textbox" id="divir">
            <p>Current waiter: <?= $row2[15]." ".$row2[16] ?></p>
            <p style="color:white;">Choose another waiter</p>
            <select name="waiter" id="waiter" class="order_type" required >
                <option value="" selected disabled hidden>Choose waiter here</option>
                <?php oci_execute($query4);
                while($row4 = oci_fetch_assoc($query4)): ?>
                    <option value="<?= $row4['E_ID'] ?>"><?= $row4['E_FNAME']." ".$row4['E_LNAME'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="sub"><input type="submit"></div>
    </form>
<?php } ?>
<div id="first">
    <div id="status"><p1>Order status: <?= $status ?></p1></div>

    <div id="divi">
<p>Order time received: <?= $time ?></p>
<p>Waiter: <?= $row2[15]." ".$row2[16] ?></p>
<p>Order total: <?= $row2[2] ?>KM</p>
<p>Client: <?= $row2[7]." ".$row2[8] ?></p>
        <?php if($_SESSION['type']==1){?>
        <img style="max-width: 80%; max-height: 400px" src="../images/<?= $row2[13] ?>" alt="Client picture">
            <?php } ?>
    <?php
    if($row2[3]=='finished')
    {?>
        <p>Time from placing the order to order being delivered to the costumer: <?= $hours!=0? $hours.' hours and': null ?> <?=$minutes2?> minutes</p>
    <?php }
    ?>
</div>
<?php if($_SESSION['type']==0 && $row2[3]=='finished'):?>
    <div id="like"><p>Liked this order last time?</p></div>
    <div class="are"><a href="repeatorder.php?id=<?=$id?>" onclick="return confirm('Are you sure? You will be redirected to cart');" style="text-decoration: none">Order again</a></div>
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
                        <p>Total price: <?= number_format($row['MI_PRICE']*$row['OL_QUANTITY'],2)?>KM</p>
                        <p>Quantity: <?= number_format($row['OL_QUANTITY'],2)?></p>
                    </a>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</section>
  <div class="m1"></div>
<?php if($_SESSION['type']==0 and $status=='pending'):?>
   <div class="are"><a href="deleteorder.php?id=<?=$id?>" onclick="return confirm('Are you sure? Order will be canceled');" style="text-decoration: none">Cancel order</a></div>
<?php endif; ?>
</div>

<?php include('../includes/footer.php') ?>

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

<?php
$_SESSION['order_placed']=false;

$_SESSION['isUpdate']=null;?>
</body>
</html>