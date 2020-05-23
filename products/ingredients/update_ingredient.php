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
    if(checkRequiredField($name) && checkRequiredField($quantity) && checkRequiredField($price)) {
        $query = oci_parse($conn, "UPDATE INGREDIENTS set IN_NAME='$name',IN_PRICE=$price,IN_QUANTITY=$quantity where IN_ID={$id}");
        oci_execute($query);

        $query3 = oci_parse($conn, "select distinct m.*, r.RL_QUANTITY
            FROM INGREDIENTS i, RECIPE_LINE r, MENU_ITEMS m
            where i.IN_ID=r.RL_INGREDIENT  and r.RL_MENU=m.MI_ID and r.RL_INGREDIENT={$id}");
        oci_execute($query3);

        while($row=oci_fetch_assoc($query3)){
            $changeInPrice=0;
            echo $row["MI_NAME"]." ".$changeInPrice." ".$orig_price." ".$price." ".$row['RL_QUANTITY']." kraj ";
            $changeInPrice=$orig_price-$price;
            echo $row["MI_NAME"]." ".$changeInPrice." ".$orig_price." ".$price." ".$row['RL_QUANTITY']." kraj ";
            $changeInPrice=$changeInPrice*$row['RL_QUANTITY'];
            echo $row["MI_NAME"]." ".$changeInPrice." ".$orig_price." ".$price." ".$row['RL_QUANTITY']." kraj ";
            $changeInPrice=$row['MI_SUPPLY_PRICE']-$changeInPrice;
            echo $row["MI_NAME"]." ".$changeInPrice." ".$orig_price." ".$price." ".$row['RL_QUANTITY']." kraj ";
            $query = oci_parse($conn, "UPDATE MENU_ITEMS set MI_SUPPLY_PRICE={$changeInPrice} where MI_ID={$row['MI_ID']}");
            oci_execute($query);
        }
        oci_commit($conn);
        header('Location: single_ingredient.php?id=' . $id);
    }
    else{
        header('Location: ../../error.php');
    }

}
else{
    header('Location: ../../error.php');
}
