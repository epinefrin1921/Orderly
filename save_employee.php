<?php

include('includes/DB.php');

session_start();
if(!isset($_SESSION['id'])){
    header('Location: index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: index.php');
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
    $salary = $_POST['salary'];
    $type = $_POST['type'];
    $manager=$_POST['manager'];

    $confirmpassword=$_POST['confirmpassword'];

    $dob2=date('d-m-Y',$dob);

    if($password!=$confirmpassword){
        header('Location: error.php');
        exit();
    }

    $password=sha1($confirmpassword);

    $select = oci_parse($conn,"SELECT E_EMAIL FROM EMPLOYEE WHERE E_EMAIL='{$email}'");
    oci_execute($select);
    if($row=oci_fetch_row($select)){
        header('Location: error.php');
        exit();
    }


    if (checkRequiredField($fname) && checkRequiredField($lname) && checkRequiredField($dob) && checkRequiredField($email) && checkRequiredField($password)) {
        $query = oci_parse($conn, "INSERT INTO EMPLOYEE(E_FNAME,E_LNAME,E_DOB,E_EMAIL,E_PASSWORD,E_SALARY, E_MANAGER, E_TYPE) 
                      VALUES('{$fname}','{$lname}',to_date('{$dob2}','DD-MM-YY'),'{$email}','{$password}', {$salary}, {$manager}, '{$type}')");
        oci_execute($query);

        oci_commit($conn);
        header('Location: index.php');
    }
    else{
        header('Location: error.php');
    }
}
else{
    header('Location: error.php');

}