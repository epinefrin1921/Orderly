<?php

include('../includes/DB.php');
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}

function checkRequiredField($value)
{
    return isset($value) && !empty($value);
}

if ($_POST) {
    $id = $_SESSION['id'];
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];

    if(checkRequiredField($_POST['password'])) {
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];

        if ($password != $confirmpassword) {
            header('Location: ../error.php');
            exit();
        }

        $password = sha1($confirmpassword);


        if (checkRequiredField($fname) && checkRequiredField($lname) && checkRequiredField($email) && checkRequiredField($password)) {
            $query = oci_parse($conn, "update EMPLOYEE
                                            set E_FNAME='{$fname}', E_LNAME='{$lname}',E_EMAIL='{$email}',E_PASSWORD='{$password}' 
                                            where E_ID={$id}");
            oci_execute($query);

            oci_commit($conn);
            header('Location: myaccount.php');
        }
    }
    else{
        if (checkRequiredField($fname) && checkRequiredField($lname) && checkRequiredField($email)) {
            $query = oci_parse($conn, "update EMPLOYEE
                                            set E_FNAME='{$fname}',E_LNAME='{$lname}',E_EMAIL='{$email}'
                                            where E_ID={$id}");
            oci_execute($query);
            oci_commit($conn);
            header('Location: myaccount.php');
        }
    }
}
else{
    header('Location: ../error.php');

}