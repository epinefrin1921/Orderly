<?php
include('includes/DB.php');

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}


if ($_POST) {
    $id = $_POST['id'];
    $quantity=$_POST['quantity'];

    $query = oci_parse($conn, 'select * from INGREDIENTS where IN_ID = ' . $id);
    oci_execute($query);
    $row = oci_fetch_assoc($query);

    $existingQuantity=$row['IN_QUANTITY'];


    $quantity2=$quantity+$existingQuantity;



    if(checkRequiredField($quantity)) {
        $query = oci_parse($conn, "UPDATE INGREDIENTS set IN_QUANTITY=$quantity2 where IN_ID={$id}");
        oci_execute($query);
        oci_commit($conn);
        header('Location: single_ingredient.php?id=' . $id);
    }
    else{
        header('Location: error.php');
    }
}
else{
    header('Location: error.php');
}