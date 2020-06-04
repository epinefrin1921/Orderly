<?php
include('../includes/DB.php');
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}
$total=$_GET['total'];
$id=$_SESSION['id'];
$waiter=$_POST['waiter'];
$query = oci_parse($conn, "INSERT INTO ORDERS(O_DATE_RECEIVED, O_TOTAL_AMOUNT, O_STATUS, O_CLIENT, O_EMPLOYEE) 
                      VALUES(sysdate, {$total},'pending', {$id}, 2)");
oci_execute($query);


$query2 = oci_parse($conn, "select max(O_ID) from orders ");
oci_execute($query2);
$row2=oci_fetch_row($query2);

foreach ($_SESSION['products']  as $line)
{
    $menu=$line[0];
    $quant=$line[1];

    $query2 = oci_parse($conn, "select * from MENU_ITEMS where MI_ID={$menu}");
    oci_execute($query2);
    $row=oci_fetch_row($query2);

    $price=$row[1];
        $supply_price=$row[3];

    $oid=$row2[0];

    $query = oci_parse($conn, "INSERT INTO ORDER_LINE(OL_MENU, OL_ORDER, OL_QUANTITY, OL_PRICE, OL_SUPPLY_PRICE) 
                      VALUES({$menu},$oid,$quant, $price, $supply_price)");
    oci_execute($query);
}
$oid=$row2[0];

$query5 = oci_parse($conn, "INSERT INTO ORDERS_HISTORY(OH_ORDER, OH_NEW_STATUS, OH_TIME_CHANGED) 
                      VALUES({$oid}, 'pending', sysdate)");
oci_execute($query5);

$_SESSION['products']=[];
$_SESSION['isUpdate']=false;
$_SESSION['product_added']=false;
$_SESSION['order_placed']=true;

header('Location: ../index.php');



