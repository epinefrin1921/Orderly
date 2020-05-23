<?php
include('../includes/DB.php');
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}
$total=$_GET['total'];
$id=$_SESSION['id'];

$query = oci_parse($conn, "INSERT INTO ORDERS(O_DATE_RECEIVED, O_TOTAL_AMOUNT, O_STATUS, O_CLIENT, O_EMPLOYEE) 
                      VALUES(sysdate, {$total},'pending', {$id}, 5)");
oci_execute($query);

$query2 = oci_parse($conn, "select max(O_ID) from orders ");
oci_execute($query2);
$row=oci_fetch_row($query2);

foreach ($_SESSION['products']  as $line)
{
    $menu=$line[0];
    $quant=$line[1];
    $oid=$row[0];
    $query = oci_parse($conn, "INSERT INTO ORDER_LINE(OL_MENU, OL_ORDER, OL_QUANTITY) 
                      VALUES({$menu},$oid,$quant)");
    oci_execute($query);
}

$_SESSION['products']=[];
$_SESSION['isUpdate']=false;
$_SESSION['product_added']=false;
$_SESSION['order_placed']=true;

header('Location: ../index.php');

