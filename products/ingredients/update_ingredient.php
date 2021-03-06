<?php
include('../../includes/DB.php');

session_start();
if(!isset($_SESSION['id'])){
    header('Location: ../../index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: ../../index.php');
    exit();
}

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}


if ($_POST) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity=$_POST['quantity'];


    if(checkRequiredField($name) && checkRequiredField($quantity) && checkRequiredField($price)) {
        $query = oci_parse($conn, "UPDATE INGREDIENTS set IN_NAME='$name',IN_PRICE=$price,IN_QUANTITY=$quantity where IN_ID={$id}");
        oci_execute($query);

        oci_commit($conn);
        header('Location: single_ingredient.php?id=' . $id);
    }
    else{
        header('Location: ../../error.php');
    }

}
else{
    header('Location: ../../error.php');
}
