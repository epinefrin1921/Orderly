<?php

include('includes/DB.php');

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}

if (checkRequiredField($_GET['id'])) {
    $id = $_GET['id'];
    $query = oci_parse($conn, "DELETE FROM MENU_ITEMS WHERE MI_ID ={$id}");
    oci_execute($query);



    $query2 = oci_parse($conn, "DELETE FROM PACKAGE_LINE WHERE PL_CHILD_ID ={$id}");
    oci_execute($query2);
    oci_commit($conn);
}
header('Location: products.php');

