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
        $_SESSION['products'][$index][1]+=$quantity;
        $_SESSION['product_added']=true;
        header('Location: ../products/products/products.php');
        exit();
    }
}
  if(!empty($_SESSION['products']))
  {
      $_SESSION['products'] = array_merge($_SESSION['products'], array(
               array($product, $quantity)
                )
      );
  }
  else{
      $_SESSION['products']=array(
          array($product, $quantity)
            );
  }
$_SESSION['product_added']=true;
header('Location: ../products/products/products.php');



