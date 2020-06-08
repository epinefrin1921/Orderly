<?php
session_start();

if(isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}

include('../includes/DB.php');

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $password=sha1($password);

    $userexist = oci_parse($conn,"select * from CLIENT where C_EMAIL = '{$email}'");
    oci_execute($userexist);

    $exists = oci_fetch_assoc($userexist);


    $query = oci_parse($conn, "select * from CLIENT where C_EMAIL = '{$email}' and C_PASSWORD = '{$password}'");
    oci_execute($query);

    $row = oci_fetch_assoc($query);

    if (!$exists) {
        $_SESSION['existance_error'] = true;
        $_SESSION['from_validate'] = true;
        header('Location: LogIn.php');
        die();
    }
   if ($row) {
        $_SESSION['id'] = $row['C_ID'];
        $_SESSION['type']= 0;
        $_SESSION['user_first_name'] = $row['C_FNAME'];
        $_SESSION['user_last_name'] = $row['C_LNAME'];
        $_SESSION['products']=[];
        $_SESSION['quantity']=[];
        $_SESSION['isUpdate']=false;
        $_SESSION['product_added']=false;
        $_SESSION['order_placed']=false;
        header('Location: ../index.php');
   }
   else {
        $_SESSION['login_error'] = true;
        $_SESSION['from_validate'] = true;
        header('Location: LogIn.php');
    }

}
?>


