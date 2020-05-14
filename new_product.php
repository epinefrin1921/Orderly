<?php
  include('includes/db.php');

  $title = 'Add new product';

?>
<!doctype html>
<html lang="en">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" href="styles/stil.css">
    <link rel="stylesheet" href="includes/products.css">
    <link rel="stylesheet" href="styles/LogInStil.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>

<h1><a href="save_product.php">Welcome to orderly</a></h1>
<form class="Login" action="save_product.php" method="POST">
    <h2>Add new product</h2>
    <div class="textbox">
        <input type="text" placeholder="Product name" name="name" value="">
    </div>
    <div class="textbox">
        <input type="number" placeholder="Product price" name="price" value="" min="0">
    </div>
    <div class="textbox">
        <input type="text" placeholder="Product description" name="description" value="">
    </div>
    <div class="textbox">
        <input type="number" placeholder="Product supply price" name="price_supply" value="" min="0">
    </div>
    <input class="butt" type="submit" name="" value="Add product to database">

</form>

</body>
</html>

