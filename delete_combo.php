<?php

session_start();
if(!isset($_SESSION['id'])){
    header('Location: index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: index.php');
    exit();
}

include('includes/DB.php');

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}

if (checkRequiredField($_GET['id'])) {
    $id = $_GET['id'];
    $query = oci_parse($conn, "update MENU_ITEMS set MI_DELETED=sysdate WHERE MI_ID ={$id}");
    oci_execute($query);

    oci_commit($conn);
    header('Location: products.php');

}
else{
    header('Location: error.php');
}
