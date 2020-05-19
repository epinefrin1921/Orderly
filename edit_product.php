<?php

include('includes/DB.php');

$title = 'Edit product';

function checkRequiredField ($value)
{
    return isset($value) && !empty($value);
}

$id = $_GET['id'];
if(checkRequiredField($id)){
    $query = oci_parse($conn, 'select * from MENU_ITEMS where MI_ID = ' . $id);
    oci_execute($query);
    $row = oci_fetch_assoc($query);

    $query2 = oci_parse($conn, "select * from INGREDIENTS");
    oci_execute($query2);
    $row2 = oci_fetch_assoc($query);

    $query3 = oci_parse($conn, "select * from RECIPE_LINE where RL_MENU=".$id);
    oci_execute($query3);
    $row3 = oci_fetch_assoc($query3);
    $is_single=false;
    if($row3){
        $is_single=true;
    }
    oci_execute($query3);


}
else{
    header('Location: error.php');
}

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
<form class="Login" action="update_product.php" method="POST">
    <h2>Edit product</h2>
    <input type="hidden" name="id" value="<?= $id ?>">
    <div class="textbox">
        <label for="name">Product name:</label>
        <input type="text" placeholder="Product name" name="name" value="<?= $row['MI_NAME'] ?>" required>
    </div>
    <div class="textbox">
        <label for="price">Product price:</label>
        <input type="number" placeholder="Product price" name="price" value="<?= $row['MI_PRICE'] ?>" min="0" step="0.5" required>
    </div>
    <div class="textbox">
        <label for="description">Product description:</label>
        <input type="text" placeholder="Product description" name="description" value="<?= $row['MI_DESCRIPTION'] ?>" required>
    </div>
    <div class="textbox">
        <label for="price_supply">Product supply price:</label>
        <input type="number" placeholder="Product supply price" name="price_supply" value="<?= $row['MI_SUPPLY_PRICE'] ?>" min="0" step="0.5" <?= $is_single?  'readonly' : null      ?>>
    </div>
    <div class="textbox">
        <label for="image">Product image:</label>
        <input type="text" placeholder="Product image" name="image" value="<?= $row['MI_IMG']?>" required>
    </div>
    <div>
        <?php while($row2=oci_fetch_assoc($query2)):?>
            <label class="container" style="display: block">
                <p style="width: 50%"><?= $row2['IN_NAME']  ?></p>
                <?php
            $match=false;
            $quant=null;
            oci_execute($query3);
            while($row3=oci_fetch_assoc($query3)){
                if($row['MI_ID']==$row3['RL_MENU'] and $row2['IN_ID']==$row3['RL_INGREDIENT'] ){
                    $match=true;
                    $quant=$row3['RL_QUANTITY'];
                    break;
                }
            };
            ?>
                <input type="checkbox" name="ingredients[]" value="<?=$row2['IN_ID']?>" <?= $match ? 'checked': null?>>
                <span class="checkmark"></span>
                <div  class="temp">
                     <span style="float: right">Quantity
                     <input type="number" name="ingrquant[]" step="0.01" value="<?= $quant!=0? number_format($quant,2):null?>">
                </div>
                </span>
                <br>
            </label>
        <?php endwhile; ?>
    </div>
    <input class="butt" type="submit" name="" value="Save edit">
</form>

</body>
</html>


