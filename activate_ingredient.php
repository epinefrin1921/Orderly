<?php


include('includes/DB.php');

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
    header('Location: error.php');
}
