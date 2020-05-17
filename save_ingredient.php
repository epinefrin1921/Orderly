<?php

include('includes/DB.php');

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
