<?php
include('../includes/DB.php');
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}
$status=$_POST['waiter'];
$id=$_GET['ID'];

$query = oci_parse($conn, "update orders set O_EMPLOYEE='{$status}' where O_ID={$id}");
oci_execute($query);

header('Location: single_order.php?id='.$id);