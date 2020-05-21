<?php

include('includes/DB.php');

session_start();
if(!isset($_SESSION['id'])){
    header('Location: index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: index.php');
    exit();
}
function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query2 = oci_parse($conn, "select i.*, m.* from RECIPE_LINE rl, MENU_ITEMS m, INGREDIENTS i where m.MI_ID=rl.RL_MENU and rl.RL_INGREDIENT=i.IN_ID and m.MI_ID={$id}");
    oci_execute($query2);

    while($row=oci_fetch_assoc($query2)){
        if($row['IN_DELETED']!=null)
        {
            header('Location: error.php');
            exit();
        }
    }

    if(checkRequiredField($id)){

        $query = oci_parse($conn, "update MENU_ITEMS set MI_DELETED=null  WHERE MI_ID ={$id}");
        oci_execute($query);
        oci_commit($conn);
    }



    header('Location: products.php');
}
else{
    header('Location: error.php');
}