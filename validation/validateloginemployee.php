<?php
session_start();

include('../includes/DB.php');

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password=sha1($password);

    $empexists = oci_parse($conn,"select * from EMAIL where E_EMAIL = '{$email}'");
    oci_execute($empexists);

    $exists = oci_fetch_assoc($empexists);

    $query = oci_parse($conn, "select * from EMPLOYEE where E_EMAIL = '{$email}' and E_PASSWORD = '{$password}'");
    oci_execute($query);

    $row = oci_fetch_assoc($query);

    if (!$exists) {
        $_SESSION['emp_existance_error'] = true;
        $_SESSION['from_validate'] = true;
        header('Location: login.php');
        die();
    }
    if ($row) {
        $_SESSION['id'] = $row['E_ID'];
        $_SESSION['type']= 1;
        $_SESSION['user_first_name'] = $row['E_FNAME'];
        $_SESSION['user_last_name'] = $row['E_LNAME'];
        $_SESSION['isUpdate']=false;
        $_SESSION['product_added']=false;
        $_SESSION['order_placed']=false;
        header('Location: ../index.php');

    }    else {
        $_SESSION['emp_login_error'] = true;
        $_SESSION['from_validate'] = true;
        header('Location: login.php');
    }
}