<?php
include('includes/DB.php');
  $title = 'Add new product';
$query = oci_parse($conn, "select * from INGREDIENTS where IN_DELETED is null ");
oci_execute($query);
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" href="styles/stil.css">
    <link rel="stylesheet" href="styles/products.css">
    <link rel="stylesheet" href="styles/LogInStil.css">
    <link rel="stylesheet" href="styles/editcombo.css">

    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
<h1><a href="index.php">Welcome to orderly</a></h1>
<form class="Login" action="save_product.php" method="POST" >
    <h2>Add new product</h2>
    <div class="textbox">
        <label for="name">Product name:</label>
        <input type="text" placeholder="Product name" name="name" value="" required>
    </div>
    <div class="textbox">
        <label for="price">Product price:</label>
        <input type="number" placeholder="Product price" name="price" value="" min="0" required step="0.01">
    </div>
    <div class="textbox">
        <label for="description">Product description:</label>
        <input type="text" placeholder="Product description" name="description" value="" required>
    </div>
    <div class="textbox">
        <label for="price_supply">Product supply price:</label>
        <input type="number" placeholder="Product supply price" name="price_supply" value="" min="0" step="0.01">
    </div>
    <div class="textbox">
        <label for="image">Product image:</label>
        <input type="text" placeholder="Product image" name="image" required>
    </div>
    <h2>Check ingredients in menu (if applicable):</h2>
    <div style="width: 100%">
        <?php while($row=oci_fetch_assoc($query)):?>
            <label class="container" style="display: block">
               <p style="width: 50%"><?= $row['IN_NAME']  ?></p>
                <input type="checkbox" name="ingredients[]" value="<?=$row['IN_ID']?>">
                <span class="checkmark"></span>
                <div  class="temp">
                     <span style="float: right">Quantity
                     <input type="number" name="ingrquant[]" step="0.01">
                </div>
                </span>
                <br>
            </label>
        <?php endwhile; ?>
    </div>
    <input class="butt" type="submit" name="" value="Add product to database">

</form>

</body>
</html>

