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
    $ingr_quant2=$_POST['ingrquant'];
    $ingr= $_POST['ingredients'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $price2 = $_POST['price_supply'];
    $id = $_POST['id'];
    $total=0;

    if(checkRequiredField($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../../images/' . $image);
    }
    else{
        $query = oci_parse($conn, "select * from MENU_ITEMS where MI_ID={$id}");
        oci_execute($query);
        $row=oci_fetch_assoc($query);
        $image = $row['MI_IMG'];
    }

    move_uploaded_file($_FILES['image']['tmp_name'], '../../images/' . $image);

    $ingr_quant=array_values(array_filter($ingr_quant2));


    if(count($ingr_quant)!==count($ingr))
    {
        header('Location: ../../error.php');
        exit();
    }
    if(count($ingr_quant)==0){
        $total=$price2;
    }
    else{
        $check='select * from INGREDIENTS where IN_ID in (';
        $check.=implode(",", $ingr);
        $check.=')';
        $query2=oci_parse($conn, $check);
        oci_execute($query2);
        $i=0;
        while($row2=oci_fetch_assoc($query2)){
            $total=$total+($row2['IN_PRICE']*$ingr_quant[$i]);
            $i++;
        }

    }

    if(checkRequiredField($name) && checkRequiredField($price) && checkRequiredField($image) && checkRequiredField($description)) {
        $query2 = oci_parse($conn, "delete from RECIPE_LINE where RL_MENU={$id}");
        oci_execute($query2);

        $query = oci_parse($conn, "UPDATE MENU_ITEMS set MI_NAME='$name', MI_DESCRIPTION='$description', MI_PRICE={$price}, MI_SUPPLY_PRICE={$total}, MI_IMG='{$image}' where MI_ID={$id}");
        oci_execute($query);

        for($i = 0; $i<count($ingr);$i++)
        {
            $father =$id;
            $quant=$ingr_quant[$i];
            $query3 = oci_parse($conn, "INSERT INTO RECIPE_LINE (RL_MENU, RL_INGREDIENT, RL_QUANTITY) 
                      VALUES ({$father}, {$ingr[$i]},{$quant})");
            oci_execute($query3);
        }
        oci_commit($conn);
        header('Location: single_product.php?id=' . $id);

    }
    else{
        header('Location: ../../error.php');
    }
}
else{
    header('Location: ../../error.php');

}