<?php
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}

$product=$_GET['ID'];
$quantity=$_POST['quantity'];

echo $product." ".$quantity." ";

if(count($_SESSION['products'])==1){
    $_SESSION['products']=[];
    header('Location: cart.php');
    exit();
}

foreach($_SESSION['products'] as $index=>$item){
    if($item[0]==$product){
        unset($_SESSION['products'][$index]);
    }
}
header('Location: cart.php');

