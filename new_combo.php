<?php
include('includes/DB.php');
$title = 'Add new product';
$query = oci_parse($conn, "select * from MENU_ITEMS where lower(MI_TYPE)='single'");
oci_execute($query);

?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" href="styles/stil.css">
    <link rel="stylesheet" href="styles/products.css">
    <link rel="stylesheet" href="styles/LogInStil.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
<h1><a href="index.php">Welcome to orderly</a></h1>
<form class="Login" action="save_combo.php" method="POST" >
    <h2>Add new combo</h2>
    <div class="textbox">
        <label for="name">Combo name:</label>
        <input type="text" placeholder="Combo name" name="name" value="" required>
    </div>
    <div class="textbox">
        <label for="price">Combo price:</label>
        <input type="number" placeholder="Combo price:" name="price" value="" min="0" required>
    </div>
    <div class="textbox">
        <label for="description">Combo description:</label>
        <input type="text" placeholder="Combo description" name="description" value="">
    </div>
    <div class="textbox">
        <label for="price_supply">Combo supply price:</label>
        <input type="number" placeholder="Combo supply price" name="price_supply" value="" min="0" >
    </div>
    <div class="textbox">
        <label for="image">Combo image:</label>
        <input type="text" placeholder="Combo image" name="image" required>
    </div>
    <div>
            <?php while($row=oci_fetch_assoc($query)):?>
                <label style="display: block">
                    <?= $row['MI_NAME']  ?>
                    <input type="checkbox" name="meals[]" value="<?=$row['MI_ID']?>">
                </label>
            <?php endwhile; ?>
    </div>
    <input class="butt" type="submit" name="" value="Add product to database">

</form>

</body>
</html>
