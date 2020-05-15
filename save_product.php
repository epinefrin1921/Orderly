<?php
include('includes/DB.php');

if ($_POST) {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $price2 = $_POST['price_supply'];
    $image = $_POST['image'];



    $query = oci_parse($conn, "INSERT INTO MENU_ITEMS (MI_NAME, MI_PRICE, MI_DESCRIPTION, MI_SUPPLY_PRICE, MI_IMG, MI_TYPE) 
                      VALUES ('{$name}', {$price},'{$description}',{$price2},'{$image}','single')");;
    oci_execute($query);
    oci_commit($conn);

    header('Location: products.php');
}