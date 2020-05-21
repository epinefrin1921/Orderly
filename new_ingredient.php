<?php

session_start();
if(!isset($_SESSION['id'])){
    header('Location: index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: index.php');
    exit();
}

include('includes/DB.php');
$title = 'Add new ingredient';
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
<form class="Login" action="save_ingredient.php" method="POST" >
    <h2>Add new ingredient</h2>
    <div class="textbox">
        <label for="name">Ingredient name:</label>
        <input type="text" placeholder="Ingredient name" name="name" value="" required>
    </div>
    <div class="textbox">
        <label for="quantity">Ingredient quantity:</label>
        <input type="number" placeholder="Ingredient quantity" name="quantity" value="" min="0" required step="0.01">
    </div>
    <div class="textbox">
        <label for="price">Product price:</label>
        <input type="number" placeholder="Ingredient price" name="price" value="" min="0" required step="0.01">
    </div>

    <input class="butt" type="submit" name="" value="Add ingredient to database">

</form>

</body>
</html>