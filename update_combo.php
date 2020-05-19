<?php
include('includes/DB.php');

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}

if ($_POST) {
    $combo_product= $_POST['meals'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $price2 = $_POST['price_supply'];
    $id = $_POST['id'];
    $image = $_POST['image'];


    if(checkRequiredField($name) && checkRequiredField($description) && checkRequiredField($image) && checkRequiredField($price)) {

        $query = oci_parse($conn, "UPDATE MENU_ITEMS set MI_NAME='$name', MI_DESCRIPTION='$description', MI_PRICE={$price}, MI_SUPPLY_PRICE={$price2}, MI_IMG='{$image}' where MI_ID={$id}");

        oci_execute($query,OCI_NO_AUTO_COMMIT);

        $query2 = oci_parse($conn, "delete from PACKAGE_LINE where PL_FATHER_ID={$id}");

        oci_execute($query2,OCI_NO_AUTO_COMMIT);

        for($i = 0; $i<count($combo_product);$i++)
        {
            $father =$id;
            $child = (int)$combo_product[$i];
            $quantity = 1;
            $query3 = oci_parse($conn, "INSERT INTO PACKAGE_LINE (PL_FATHER_ID, PL_CHILD_ID, PL_QUANTITY) 
                      VALUES ({$father}, {$child},{$quantity})");
            oci_execute($query3, OCI_NO_AUTO_COMMIT);
        }

        $query2 = oci_parse($conn, "select pl.*, m.* from PACKAGE_LINE pl, MENU_ITEMS m where m.MI_ID=pl.PL_CHILD_ID and PL_FATHER_ID={$id}");
        oci_execute($query2, OCI_NO_AUTO_COMMIT);

        while($row=oci_fetch_assoc($query2)){
            if($row['MI_DELETED']!=null)
            {
                header('Location: error.php');
                oci_rollback($conn);
                exit();
            }
        }

        oci_commit($conn);
        header('Location: single_combo.php?id=' . $id);
    }
    else{
        header('Location: error.php');
    };
}
else{
    header('Location: error.php');
}
