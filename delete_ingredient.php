<?php


include('includes/DB.php');

function checkRequiredField($value)
{
    return isset($value) && !empty($value);
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = oci_parse($conn, "update INGREDIENTS set IN_DELETED=sysdate WHERE IN_ID ={$id}");
    oci_execute($query);

    $query2 = oci_parse($conn, "select distinct m.MI_ID, m.MI_NAME
         from  MENU_ITEMS m, INGREDIENTS i, RECIPE_LINE r
         where m.MI_ID=r.RL_MENU and r.RL_INGREDIENT=i.IN_ID and i.IN_ID={$id}");
    oci_execute($query2);

    while ($row=oci_fetch_assoc($query2)){

        $query3 = oci_parse($conn, "update MENU_ITEMS set MI_DELETED=sysdate WHERE MI_ID ={$row['MI_ID']}");
        oci_execute($query3);

        $query3 = oci_parse($conn, "select * FROM PACKAGE_LINE WHERE PL_CHILD_ID ={$row['MI_ID']}");
        oci_execute($query3);

        while($row=oci_fetch_assoc($query3)){
            $FatherID=$row['PL_FATHER_ID'];
            $query4 = oci_parse($conn, "update MENU_ITEMS set MI_DELETED=sysdate WHERE MI_ID ={$FatherID}");
            oci_execute($query4);
        };
    };

    oci_commit($conn);
    header('Location: storage.php');
}
else{
    header('Location: error.php');
}
