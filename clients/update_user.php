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

    if(checkRequiredField($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $image);
        echo 'new phoyo';
    }
    else{
        $query = oci_parse($conn, "select * from CLIENT where C_ID={$id}");
        oci_execute($query);
        $row=oci_fetch_assoc($query);
        $image = $row['C_IMAGE'];
    }
    move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $image);

   if(checkRequiredField($_POST['password'])) {
       $password = $_POST['password'];
       $confirmpassword = $_POST['confirmpassword'];

       if ($password != $confirmpassword) {
           header('Location: ../error.php');
           exit();
       }
       $password = sha1($confirmpassword);


       if (checkRequiredField($fname) && checkRequiredField($lname) && checkRequiredField($email) && checkRequiredField($password)) {
           $query = oci_parse($conn, "update CLIENT 
                                            set C_FNAME='{$fname}',C_LNAME='{$lname}',C_EMAIL='{$email}',C_PASSWORD='{$password}', C_IMAGE='{$image}' 
                                            where C_ID={$id}");
           oci_execute($query);

           oci_commit($conn);
           header('Location: myaccount.php');
       }
   }
    else{
        if (checkRequiredField($fname) && checkRequiredField($lname) && checkRequiredField($email)) {
            $query = oci_parse($conn, "update CLIENT 
                                            set C_FNAME='{$fname}',C_LNAME='{$lname}',C_EMAIL='{$email}', C_IMAGE='{$image}'
                                            where C_ID={$id}");
            oci_execute($query);
            oci_commit($conn);
            header('Location: myaccount.php');
        }
    }
}
else{
    header('Location: ../error.php');

}