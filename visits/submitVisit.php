<?php
include('../includes/DB.php');

session_start();
$id=0;
if(isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}
function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}
if($_POST){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = oci_parse($conn,"INSERT INTO VISITS(V_FNAME, V_LNAME, V_EMAIL, V_PHONE, V_DATE, V_CID)
                       VALUES ('{$fname}','{$lname}', '{$email}', '{$phone}', sysdate, {$id})");
    oci_execute($query);
    oci_commit($conn);

    header('Location: thankyou.php');
}