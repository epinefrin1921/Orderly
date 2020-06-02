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
        $found=false;
        $query = oci_parse($conn, "select * from ORDERS where O_DATE_RECEIVED>to_date('{$start}','YYYY-MM-DD') and O_DATE_RECEIVED<to_date('{$end}','YYYY-MM-DD') ");
        oci_execute($query);
        $totalamount=0;
        $number=0;
        while($row=oci_fetch_assoc($query)){
            $totalamount=$totalamount+$row['O_TOTAL_AMOUNT'];
            $number=$number+1;
            $found=true;
        };
        $query2 = oci_parse($conn, "select ol.OL_MENU, m.MI_NAME, m.MI_PRICE , sum(ol.OL_QUANTITY) as t
                             FROM ORDER_LINE ol, MENU_ITEMS m, ORDERS o
                             where m.MI_ID=ol.OL_MENU and o.O_ID=ol.OL_ORDER and O_DATE_RECEIVED>to_date('{$start}','YYYY-MM-DD') and O_DATE_RECEIVED<to_date('{$end}','YYYY-MM-DD')
                             group by ol.OL_MENU, m.MI_NAME, m.MI_PRICE
                             order by t desc ");
        oci_execute($query2);
        if($row2=oci_fetch_row($query2)) {
            $found=true;
            $item_id = $row2[0];
            $item_name = $row2[1];
            $item_number = $row2[3];
        }
        $query3 = oci_parse($conn, "select ol.OL_MENU,m.MI_NAME, sum(ol.OL_QUANTITY) as t,  sum(ol.OL_QUANTITY*(ol.OL_PRICE-ol.OL_SUPPLY_PRICE)) as p, m.MI_ID
                             FROM ORDER_LINE ol, MENU_ITEMS m, ORDERS o
                             where m.MI_ID=ol.OL_MENU and o.O_ID=ol.OL_ORDER and O_DATE_RECEIVED>to_date('{$start}','YYYY-MM-DD') and O_DATE_RECEIVED<to_date('{$end}','YYYY-MM-DD')
                             group by m.MI_ID, ol.OL_MENU,m.MI_NAME");
        oci_execute($query3);
        $start = date('d.m.Y', strtotime($start));
        $end = date('d.m.Y', strtotime($end));
    }
}
$title='Financial results';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles/stil.css">
    <link rel="stylesheet" href="../styles/finance.css">
    <?php include('../includes/head.php') ?>
</head>

<body>
<?php include '../includes/header.php';?>
<div id="helping"></div>

<div id="fini">
    <form action="finance.php" method="post">
        <label for="start" style="color: white;">Start date</label>
        <input type="date" id="start" name="start">
        <label for="end" style="color:white; margin-left:10px;">End date</label>
        <input type="date" id="end" name="end">
        <div id="f1"><input type="submit" style="width: 30%;"></div>
    </form>
</div>
<main id="finmain" class="wrap">
<?php if($_POST and $found):?>
<div class="fin1"><h3>Period: <?=$start?> to <?=$end?>, excluding last day</h3></div>
<div class="fin1"><h3>Total money made for a given period: <?=$totalamount?></h3></div>
    <div class="fin1"><h3>Number of orders for a given period: <?=$number?></h3></div>
    <div class="fin1"><h3>Best sold item is : <a href="../products/products/single_product.php?id=<?=$item_id?>" style="color:red; text-decoration: none"><?=$item_name?></a> , that has been sold <span style="color:green;"><?=$item_number?></span> times</h3></div>
    <?php  while($row3=oci_fetch_assoc($query3)): ?>
        <div id="pok">
            <?php
                if(is_null($row3['T'])){
                    $no=0;
                    $row3['P']=0;
                }
                else{
                    $no=$row3['T'];
                }
            ?>
            <div class="fin1"><h3 style="color:#89253e; text-align: center">Item name: <?=$row3['MI_NAME']?></h3></div>
            <div class="fin1"><h4 style="color:#89253e; text-align: center"><a href="../products/products/single_product.php?id=<?=$row3['OL_MENU']?>" style="text-decoration: none;color:#89253e;">Link to the item</a></h4></div>
            <div class="fin1"><h4 style="color:#89253e; text-align: center">Total amount sold: <?=$no?></h4></div>
            <div class="fin1"><h4 style="color:#89253e; text-align: center">Total money earned for this item: <?=$row3['P']?></h4></div>

        </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php if($_POST and !$found):?>
    <h1>No orders were found in given period!</h1>
<?php endif; $found=false; ?>

</main>
<?php include '../includes/footer.php'; ?>
</body>
</html>