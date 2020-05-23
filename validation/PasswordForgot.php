<?php

if(isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}

$title = 'Password recovery';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('../includes/head.php') ?>
    <link rel="stylesheet" href="../styles/Fpass.css">
</head>
<body>
<h1>Welcome to orderly</h1>
<div class="Login">
    <h2>Password recovery</h2>
    <p>Enter your email address below. You will get mail from our support with instructions how to recover you password.<br><br> Thank you for using our site!</p>
    <div class="textbox">
        <input type="text" placeholder="E-mail" name="" value="">
    </div>
    <input class="butt" type="submit" name="" value="Submit">
</div>
</body>
</html>