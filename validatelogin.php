<?php
session_start();



include('includes/db.php');

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $query = oci_parse($conn, "select * from CLIENT where C_EMAIL = '{$email}' and C_PASSWORD = '{$password}'");
    oci_execute($query);



    $row = oci_fetch_assoc($query);


    if ($row) {
        $_SESSION['id'] = $row['C_ID'];
        $_SESSION['user_first_name'] = $row['C_FNAME'];
        $_SESSION['user_last_name'] = $row['C_LNAME'];
        header('Location: index.php');

    } else {
        header("Location: error.php");
    }
}