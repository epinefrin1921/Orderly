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
    $ingr= $_POST['ingredients'];
    $ingr_quant2=$_POST['ingrquant'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $price2 = $_POST['price_supply'];
    $image = $_FILES['image']['name'];
    $date = date("d-m-y H:i:s");
    $total=0;
    move_uploaded_file($_FILES['image']['tmp_name'], '../../images/' . $image);

    $ingr_quant=array_values(array_filter($ingr_quant2));

    $check='select * from INGREDIENTS where IN_ID in (';
    $check.=implode(",", $ingr);
    $check.=')';

    if(!checkRequiredField($price2)){
        $query2=oci_parse($conn, $check);
        oci_execute($query2);
        $i=0;
        while($row2=oci_fetch_assoc($query2)){
            $total=$total+($row2['IN_PRICE']*$ingr_quant[$i]);
            $i++;
        }
    }
    else{
        $total=$price2;
    }

    if(checkRequiredField($name) && checkRequiredField($price) && checkRequiredField($image) && checkRequiredField($description)) {
        $query = oci_parse($conn, "INSERT INTO MENU_ITEMS (MI_NAME, MI_PRICE, MI_DESCRIPTION, MI_SUPPLY_PRICE, MI_IMG, MI_TYPE, MI_CREATED, MI_DELETED) 
                      VALUES ('{$name}', {$price},'{$description}',{$total}},'{$image}','single', to_date('{$date}','DD-MM-YY HH24:MI:SS'), NULL)");
        oci_execute($query);

        $query2=oci_parse($conn, "select * from MENU_ITEMS where  MI_NAME='{$name}' and MI_DESCRIPTION='{$description}'");

        oci_execute($query2);

        $row = oci_fetch_row($query2);

        for($i = 0; $i<count($ingr);$i++)
        {
            $father =(int)$row[0];
            $quant=$ingr_quant[$i];
            $query3 = oci_parse($conn, "INSERT INTO RECIPE_LINE (RL_MENU, RL_INGREDIENT, RL_QUANTITY) 
                      VALUES ({$father}, {$ingr[$i]},{$quant})");
            oci_execute($query3);
        }
        oci_commit($conn);
        header('Location: products.php');

    }
    else{
        header('Location: ../../error.php');
    }
}
else{
    header('Location: ../../error.php');

}