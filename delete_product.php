<?php

include('includes/DB.php');

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if(checkRequiredField($id)){

        $query3 = oci_parse($conn, "select * FROM PACKAGE_LINE WHERE PL_CHILD_ID ={$id}");
        oci_execute($query3);


        $query2 = oci_parse($conn, "delete from RECIPE_LINE where RL_MENU={$id}");

        oci_execute($query2);
        oci_commit($conn);

       while($row=oci_fetch_assoc($query3)){
           $FatherID=$row['PL_FATHER_ID'];
           echo implode(" ,",$row);
           $query4 = oci_parse($conn, "DELETE FROM MENU_ITEMS WHERE MI_ID ={$FatherID}");
           oci_execute($query4);
           oci_commit($conn);
       };

        $query = oci_parse($conn, "DELETE FROM MENU_ITEMS WHERE MI_ID ={$id}");
        oci_execute($query);
        oci_commit($conn);

    }
    header('Location: products.php');
}
else{
    header('Location: error.php');
}
