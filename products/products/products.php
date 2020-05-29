<?php

$title = 'Products';
include('../../includes/DB.php');

session_start();
 $query = oci_parse($conn, "select * from MENU_ITEMS where MI_DELETED is null and lower(MI_TYPE)='single'");
$query2 = oci_parse($conn, "select * from MENU_ITEMS where MI_DELETED is null and lower(MI_TYPE)='combo'");
 oci_execute($query);
oci_execute($query2);


?>

<!doctype html>
<html lang="en">
<head>
    <?php include('../../includes/head.php') ?>
    <link rel="stylesheet" href="../../styles/cart.css">
    <link rel="stylesheet" href="../../styles/stil.css">
    <link rel="stylesheet" href="../../styles/products.css">
</head>

<body>
<?php include('../../includes/header.php') ?>
<div id="helping"></div>


    <div class="wrap2">
<?php
if (isset($_SESSION['id']) and $_SESSION['type']==1):?>
    <p><a href="new_product.php">Add new product</a> </p>
    <p><a href="../combos/new_combo.php">Add new combo</a> </p>
    <p><a href="../ingredients/storage.php">Open storage</a></p>
    <p><a href="arhive.php">Open deleted products and combos</a></p>
<?php endif;?>
    </div>
<div class="wrap2">
<?php
if(!isset($_SESSION['id']) and !isset($_SESSION['products'])){?>
    <p>Not registered yet? <a href="../../validation/Register.php">Register now!</a> <a href="../../validation/LogIn.php">Log in</a> </p>
<?php }
else if (isset($_SESSION['id']) and $_SESSION['type']==0 and (is_null($_SESSION['products']) or count($_SESSION['products'])==0)):?>
    <p class="up">Your shopping cart is empty!</p>
<?php endif;?>
</div>
<div class="wrap2">
<?php
if (isset($_SESSION['products']) and count($_SESSION['products'])!=0):?>
    <p class="open_cart"><a href="../../orders/cart.php" style="text-decoration: none"><i class="fas fa-shopping-cart"></i> Open cart</a></p>
<?php endif;?>
<?php
if (isset($_SESSION['id']) and $_SESSION['type']==0  and  $_SESSION['product_added']):?>
<p class="up">Product added</p>
<?php endif;?>


</div>


<h1 id="naslov3">Products:</h1>

<section class="wrap2" id="s3">
<?php while($row=oci_fetch_assoc($query)):?>
    <div class="container">
        <div class="container2">
            <form method="post" action="../../orders/addtocart.php?ID=<?php echo $row['MI_ID']; ?>">
                <a href="single_product.php?id=<?= $row['MI_ID'] ?>" class="info-more">
                    <img src="../../images/<?=$row['MI_IMG']?>">
                    <p><?= $row['MI_NAME'] ?></p>
                    <p>Price: <?= number_format($row['MI_PRICE'],2)?>KM</p>
                </a>
                <?php if(isset($_SESSION['id']) and $_SESSION['type']==0){?>
                      <div class="cart-action"><label for="quantity">Quantity:</label> <input type="number" class="product-quantity" name="quantity" value="1" min="1"/><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
                 <?php } ?>
            </form>
            </div>
    </div>
<?php endwhile; ?>
</section>

<div class="wrap2 jumbotron">
    <h1 id="naslov3">Combos:</h1>
</div>

<section class="wrap2" id="s3">
    <?php while($row=oci_fetch_assoc($query2)):?>

        <div class="container">
            <div class="container2">
                <form method="post" action="../../orders/addtocart.php?ID=<?php echo $row['MI_ID']; ?>">
                    <a href="../combos/single_combo.php?id=<?= $row['MI_ID'] ?>" class="info-more">
                        <img src="../../images/<?=$row['MI_IMG']?>">
                        <p><?= $row['MI_NAME'] ?></p>
                        <p>Price: <?= number_format($row['MI_PRICE'],2)?>KM</p>
                        <p>You save <?=number_format($row['MI_SUPPLY_PRICE']-$row['MI_PRICE'],2) ?>KM </p>
                    </a>
                    <?php if(isset($_SESSION['id'])and $_SESSION['type']==0){?>
                    <div class="cart-action"><label for="quantity">Quantity:</label> <input type="number" class="product-quantity" name="quantity" value="1" min="1"/><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
                    <?php } ?>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</section>

<?php
$_SESSION['product_added']=false;
include('../../includes/footer.php') ?>
</body>
</html>
