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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if(checkRequiredField($id)){

        $query3 = oci_parse($conn, "select * FROM PACKAGE_LINE WHERE PL_CHILD_ID ={$id}");
        oci_execute($query3);


       while($row=oci_fetch_assoc($query3)){
           $FatherID=$row['PL_FATHER_ID'];
           $query4 = oci_parse($conn, "update MENU_ITEMS set MI_DELETED=sysdate WHERE MI_ID ={$FatherID}");
           oci_execute($query4);
       };

        $query = oci_parse($conn, "update MENU_ITEMS set MI_DELETED=sysdate  WHERE MI_ID ={$id}");
        oci_execute($query);
        oci_commit($conn);

    }
    header('Location: products.php');
}
else{
    header('Location: error.php');
}
