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
$query6=oci_parse($conn, "delete from NOTIFICATIONS where N_CID = 0");
oci_execute($query6);
oci_commit($conn);

header('Location: myaccount.php');
exit();