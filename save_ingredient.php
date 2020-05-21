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

    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];



    if (checkRequiredField($name) && checkRequiredField($quantity) && checkRequiredField($price) ) {
        $query = oci_parse($conn, "INSERT INTO INGREDIENTS (IN_NAME, IN_QUANTITY, IN_PRICE) 
                      VALUES ('{$name}', {$quantity},{$price})");
        oci_execute($query);
        oci_commit($conn);
        header('Location: storage.php');
    }
    else{
        header('Location: error.php');
    }


}
else{
    header('Location: error.php');
}
