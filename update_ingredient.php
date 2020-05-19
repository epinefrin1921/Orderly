<?php
include('includes/DB.php');

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}


if ($_POST) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity=$_POST['quantity'];

    $query2 = oci_parse($conn, "select * from INGREDIENTS where IN_ID={$id}");
    oci_execute($query2);
    $row = oci_fetch_assoc($query2);
    $orig_price=$row['IN_PRICE'];
    $changeInPrice=$orig_price-$price;

    if(checkRequiredField($name) && checkRequiredField($quantity) && checkRequiredField($price)) {
        $query = oci_parse($conn, "UPDATE INGREDIENTS set IN_NAME='$name',IN_PRICE=$price,IN_QUANTITY=$quantity where IN_ID={$id}");
        oci_execute($query);
        oci_commit($conn);

       /* $query2 = oci_parse($conn, "update MENU_ITEMS
              set MI_SUPPLY_PRICE=MI_SUPPLY_PRICE-{$changeInPrice}
              where exists(select m.*, i.*, RL_QUANTITY
              from INGREDIENTS i, RECIPE_LINE r, MENU_ITEMS m
              where IN_ID=r.RL_INGREDIENT and m.MI_ID=r.RL_MENU and i.IN_ID={$id})");
        oci_execute($query2);
        oci_commit($conn);*/

        header('Location: single_ingredient.php?id=' . $id);

    }
    else{
        header('Location: error.php');
    }

}
else{
    header('Location: error.php');
}
