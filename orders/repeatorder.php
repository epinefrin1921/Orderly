<?php
include('../includes/DB.php');
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}

$id=$_GET['id'];
$_SESSION['products']=[];

$query=oci_parse($conn, "select * from ORDER_LINE where OL_ORDER={$id}");
oci_execute($query);

while($row=oci_fetch_assoc($query)){
    if(empty($_SESSION['products']))
    {
        $_SESSION['products']=array(
            array($row['OL_MENU'], $row['OL_QUANTITY'])
        );
    }
    else{
        $_SESSION['products'] = array_merge($_SESSION['products'], array(
                array($row['OL_MENU'], $row['OL_QUANTITY'])
            )
        );
    }
};

header('Location: cart.php');

