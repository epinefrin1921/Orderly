<?php

session_start();
if(!isset($_SESSION['id'])){
    header('Location: ../../index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: ../../index.php');
    exit();
}

include('../../includes/DB.php');
$title = 'Edit product';
$id = $_GET['id'];

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}
if(checkRequiredField($id)){
    $query = oci_parse($conn, 'select * from MENU_ITEMS where MI_ID = ' . $id);
    oci_execute($query);
    $row = oci_fetch_assoc($query);
    $query2 = oci_parse($conn, "select * from MENU_ITEMS where MI_DELETED is null and lower(MI_TYPE)='single'");
    oci_execute($query2);
    $query3 = oci_parse($conn, 'select * from PACKAGE_LINE where PL_FATHER_ID='.$id);
    oci_execute($query3);
}
else{
    header('Location: ../../error.php');
}
?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <?php include('../../includes/head.php') ?>
    <link rel="stylesheet" href="../../styles/LogInStil.css">
    <link rel="stylesheet" href="../../styles/editcombo.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
<h1><a href="../../index.php">Welcome to orderly</a></h1>
<form class="Login" action="update_combo.php" method="POST" enctype="multipart/form-data">
    <h2>Edit combo</h2>
    <input type="hidden" name="id" value="<?= $id ?>">
    <div class="textbox">
        <label for="name">Product name:</label>
        <input type="text" placeholder="Product name" name="name" value="<?= $row['MI_NAME'] ?>" required>
    </div>
    <div class="textbox">
        <label for="price">Product price:</label>
        <input type="number" placeholder="Product price" name="price" value="<?= $row['MI_PRICE'] ?>" min="0" step="0.1">
    </div>
    <div class="textbox">
        <label for="description">Product description:</label>
        <input type="text" placeholder="Product description" name="description" value="<?= $row['MI_DESCRIPTION'] ?>" required>
    </div>
    <div class="textbox">
        <label for="price_supply">Combo products price combined:</label>
        <input type="number" placeholder="Product supply price" name="price_supply" value="<?= $row['MI_SUPPLY_PRICE'] ?>" min="0" step="0.1" readonly>
    </div>
    <div class="textbox">
        <label for="image">Combo image:</label>
        <input type="file" placeholder="Product image" id="image" name="image">
    </div>
    <h2>Check products in combo:</h2>
    <div>
        <?php while($row=oci_fetch_assoc($query2)):?>
            <label class="container" style="display: block; font-size: 1.5rem">
                <?= $row['MI_NAME']  ?>
                <?php
                $match=false;
                oci_execute($query3);
                while($row2=oci_fetch_assoc($query3)){
                    if($row['MI_ID']==$row2['PL_CHILD_ID']){
                     $match=true;
                    }
                };
                ?>
                <input type="checkbox" name="meals[]" value="<?=$row['MI_ID']?>" <?= $match ? 'checked': null?>>
                <span class="checkmark"></span>
            </label>
        <?php endwhile; ?>
    </div>
    <input class="butt" type="submit" name="" value="Edit and save to database">
</form>
</body>
</html>