<?php


include('includes/DB.php');

function checkRequiredField($value)
{
    return isset($value) && !empty($value);
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = oci_parse($conn, "DELETE FROM INGREDIENTS WHERE IN_ID ={$id}");
    oci_execute($query);



    $query2 = oci_parse($conn, "DELETE FROM RECIPE_LINE WHERE RL_INGREDIENT ={$id}");
    oci_execute($query2);
    oci_commit($conn);
}
header('Location: storage.php');
