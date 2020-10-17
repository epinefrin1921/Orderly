<?php
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}

$product=$_GET['ID'];
$quantity=$_POST['quantity'];

foreach($_SESSION['products'] as $index=>$item){
    if($item[0]==$product){
        $_SESSION['products'][$index][1]=$quantity;
        break;
    }
}

$_SESSION['isUpdate']=true;
header('Location: cart.php');



