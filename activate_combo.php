<?php

include('includes/DB.php');

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}

if (checkRequiredField($_GET['id'])) {
    $id = $_GET['id'];

    $query2 = oci_parse($conn, "select pl.*, m.* from PACKAGE_LINE pl, MENU_ITEMS m where m.MI_ID=pl.PL_CHILD_ID and PL_FATHER_ID={$id}");
    oci_execute($query2);

    while($row=oci_fetch_assoc($query2)){
        if($row['MI_DELETED']!=null)
        {
            header('Location: error.php');
            exit();
        }
    }

    $query = oci_parse($conn, "update MENU_ITEMS set MI_DELETED=null WHERE MI_ID ={$id}");
    oci_execute($query);

    oci_commit($conn);
    header('Location: products.php');
}
else{
    header('Location: error.php');
}