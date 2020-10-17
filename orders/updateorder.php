<?php
include('../includes/DB.php');
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}
$status=$_POST['type'];
$id=$_GET['ID'];

$query = oci_parse($conn, "update orders set O_STATUS='{$status}' where O_ID={$id}");
oci_execute($query);


$query5 = oci_parse($conn, "INSERT INTO ORDERS_HISTORY(OH_ORDER, OH_NEW_STATUS, OH_TIME_CHANGED) 
                      VALUES({$id}, '{$status}', sysdate)");
oci_execute($query5);

header('Location: single_order.php?id='.$id);


