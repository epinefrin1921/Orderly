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
    <p>Please contact out IT depatment at e-mail: info@orderly.com<br><br> Thank you for using our site!</p>
</div>
</body>
</html>