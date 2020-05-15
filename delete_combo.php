<?php

include('includes/DB.php');

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = oci_parse($conn, "DELETE FROM MENU_ITEMS WHERE MI_ID ={$id}");

    oci_execute($query);

    oci_commit($conn);

    header('Location: products.php');

}