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

function checkRequiredField($value)
{
    return isset($value) && !empty($value);
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = oci_parse($conn, "update INGREDIENTS set IN_DELETED=null WHERE IN_ID ={$id}");
    oci_execute($query);

    oci_commit($conn);
    header('Location: storage.php');
}
else{
    header('Location: ../../error.php');
}
