<?php

include('../includes/DB.php');

session_start();
if(isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}
if(isset($_SESSION['id']) and $_SESSION['type']==0){
    header('Location: ../index.php');
    exit();
}

function checkRequiredField($value)
{
    return isset($value) && !empty($value);
}

if ($_POST) {
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $dob=strtotime($_POST['DOB']);
    $email=$_POST['email'];
    $password=$_POST['password'];
    $confirmpassword=$_POST['confirmpassword'];
    $dob2=date('d-m-Y',$dob);
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $image);


    $select = oci_parse($conn,"SELECT C_EMAIL FROM CLIENT WHERE C_EMAIL='{$email}'");
    oci_execute($select);
    if($row=oci_fetch_row($select)){
        header('Location: ../error.php');
        exit();
    }
    if($password!=$confirmpassword){
        header('Location: ../error.php');
        exit();
    }

    $password=sha1($confirmpassword);


    if (checkRequiredField($fname) && checkRequiredField($lname) && checkRequiredField($dob) && checkRequiredField($email) && checkRequiredField($password)) {
        $query = oci_parse($conn, "INSERT INTO CLIENT(C_FNAME,C_LNAME,C_DOB,C_EMAIL,C_PASSWORD, C_IMAGE) 
                      VALUES('{$fname}','{$lname}',to_date('{$dob2}','DD-MM-YY'),'{$email}','{$password}', '{$image}')");
        oci_execute($query);

        oci_commit($conn);
        header('Location: ../index.php');
    }
    else{
        header('Location: ../error.php');
    }
}
else{
    header('Location: ../error.php');

}