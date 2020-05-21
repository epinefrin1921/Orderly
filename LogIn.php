<?php

$title = 'Log in';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles/LogInStil.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <?php include('includes/head.php') ?>
</head>

<body>
<h1><a href="index.php">Welcome to orderly</a></h1>
<form class="Login" action="validatelogin.php" method="post">
    <h2>Log in</h2>
    <div class="textbox">
        <i style='font-size:24px' class='far'>&#xf2bd;</i>
        <input type="email" placeholder="E-mail" name="email" value="">
    </div>
    <div class="textbox">
        <i class="fas fa-lock"></i>
        <input type="password" placeholder="Password" name="password" value="">
    </div>
    <input class="butt" type="submit" name="" value="Sign In">
    <div id="pass"><a href="PasswordForgot.php" id="pw">Forgot password?</a> |
        <a href="Register.php" id="pw">Don't have an account?</a></div>

</form>


</body>
</html>