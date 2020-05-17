<?php
include('includes/DB.php');

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}

if ($_POST) {
    $ingr= $_POST['ingredients'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $price2 = $_POST['price_supply'];
    $image = $_POST['image'];


    if(checkRequiredField($name) && checkRequiredField($price) && checkRequiredField($image) && checkRequiredField($description)){
        $query = oci_parse($conn, "INSERT INTO MENU_ITEMS (MI_NAME, MI_PRICE, MI_DESCRIPTION, MI_SUPPLY_PRICE, MI_IMG, MI_TYPE) 
                      VALUES ('{$name}', {$price},'{$description}',{$price2},'{$image}','single')");;
        oci_execute($query);
        oci_commit($conn);

        $query2=oci_parse($conn, "select * from MENU_ITEMS where  MI_NAME='{$name}'");

        oci_execute($query2);

        $row = oci_fetch_row($query2);

        oci_commit($conn);

        for($i = 0; $i<count($ingr);$i++)
        {
            $father =(int)$row[0];
            $quant=1;
            $query3 = oci_parse($conn, "INSERT INTO RECIPE_LINE (RL_MENU, RL_INGREDIENT, RL_QUANTITY) 
                      VALUES ({$father}, {$ingr[$i]},{$quant})");
            oci_execute($query3);
        }
        header('Location: products.php');

    }
    else{
        header('Location: error.php');
    }
}
else{
    header('Location: error.php');
}
