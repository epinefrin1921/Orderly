<?php

include('includes/DB.php');

$title = 'Edit product';

$id = $_GET['id'];

$query = oci_parse($conn, 'select * from MENU_ITEMS where MI_ID = ' . $id);
oci_execute($query);
$row = oci_fetch_assoc($query);
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" href="styles/stil.css">
    <link rel="stylesheet" href="styles/products.css">
    <link rel="stylesheet" href="styles/LogInStil.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>

<h1><a href="index.php">Welcome to orderly</a></h1>
<form class="Login" action="update_product.php" method="POST">
    <h2>Edit product</h2>
    <input type="hidden" name="id" value="<?= $id ?>">
    <div class="textbox">
        <label for="name">Product name:</label>
        <input type="text" placeholder="Product name" name="name" value="<?= $row['MI_NAME'] ?>">
    </div>
    <div class="textbox">
        <label for="price">Product price:</label>
        <input type="number" placeholder="Product price" name="price" value="<?= $row['MI_PRICE'] ?>" min="0">
    </div>
    <div class="textbox">
        <label for="description">Product description:</label>
        <input type="text" placeholder="Product description" name="description" value="<?= $row['MI_DESCRIPTION'] ?>">
    </div>
    <div class="textbox">
        <label for="price_supply">Product supply price:</label>
        <input type="number" placeholder="Product supply price" name="price_supply" value="<?= $row['MI_SUPPLY_PRICE'] ?>" min="0">
    </div>
    <div class="textbox">
        <label for="image">Product image:</label>
        <input type="text" placeholder="Product image" name="image" value="<?= $row['MI_IMG']?>">
    </div>
    <input class="butt" type="submit" name="" value="Save edit">
</form>

</body>
</html>


