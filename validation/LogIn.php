<?php
session_start();

if(isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}
$title = 'Log in';

if(isset($_SESSION['from_validate'])) {
    unset($_SESSION['from_validate']) ;
} else{
    unset($_SESSION['login_error']);
    unset($_SESSION['existance_error']);
    unset($_SESSION['emp_login_error']);
    unset($_SESSION['emp_existance_error']);
}

if(isset($_SESSION['login_error'])) {
   $credential_error = true;
   unset ($_SESSION['login_error']);
} else {
    $credential_error=false;
}
if(isset($_SESSION['existance_error'])) {
    $not_existing = true;
    unset ($_SESSION['existance_error']);
} else {
    $not_existing = false;
}

if(isset($_SESSION['emp_login_error'])) {
    $emp_credential_error = true;
    unset ($_SESSION['emp_login_error']);
} else {
    $emp_credential_error=false;
}
if(isset($_SESSION['emp_existance_error'])) {
    $emp_not_existing = true;
    unset ($_SESSION['emp_existance_error']);
} else {
    $emp_not_existing = false;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles/LogInStil.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <?php include('../includes/head.php') ?>
</head>

<body>
<h1><a href="../index.php">Welcome to orderly</a></h1>
<main>
<section class="sek">
<form class="Login" action="validatelogin.php" onsubmit="return ValidateLogin()" method="post" name="clogin">
    <h2>Log in</h2>

    <div class="textbox">
        <i style='font-size:24px' class='far'>&#xf2bd;</i>
        <input type="email" placeholder="E-mail" name="email" value="">
    </div>
    <div class ="erroneus" id="usererror"></div>
    <div class="textbox">
        <i class="fas fa-lock"></i>
        <input type="password" placeholder="Password" name="password" value="">
    </div>
    <div class ="erroneus" id="loginerror"></div>
    <input class="butt" type="submit" name="" value="Sign In">
    <div id="pass"><a href="PasswordForgot.php" id="pw">Forgot password?</a> |
        <a href="Register.php" id="pw">Don't have an account?</a></div>
</form>
</section>

<section class="sek">
    <form class="Login" action="validateloginemployee.php" onsubmit="return EmpValidateLogin()" method="post" name="emplogin">
        <h2>Log in as employee</h2>
        <div class="textbox">
            <i style='font-size:24px' class='far'>&#xf2bd;</i>
            <input type="email" placeholder="E-mail" name="email" value="">
        </div>
        <div class ="erroneus" id="empusererror"></div>
        <div class="textbox">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" value="">
        </div>
        <div class ="erroneus" id="emploginerror"></div>
        <input class="butt" type="submit" name="" value="Sign In">
        <div id="pass"><a href="PasswordForgot.php" id="pw">Forgot password?</a> |
            <a href="Register.php" id="pw">Don't have an account?</a></div>
    </form>
</section>
</main>

<script type="text/javascript">

    //OVO JE VALIDACIJA ZA RADNIKA ISPOD
    var emp_emailbox = document.forms['emplogin']['email'];
    var emp_passbox = document.forms['emplogin'] ['password'];
    var emp_login_error=document.getElementById('emploginerror');
    var emp_user_error=document.getElementById('empusererror');
    var emp_incorrect = "<?php echo $emp_credential_error?>";
    var emp_nouser= "<?php echo $emp_not_existing?>";

    if (emp_nouser) {
        emp_user_error.textContent = "No existing user found!";
        emp_emailbox.parentElement.style.borderBottom = "1px solid red";
    }

    if (emp_incorrect){
        emp_login_error.textContent="Incorrect password!";
        emp_passbox.parentElement.style.borderBottom ="1px solid red";
    }

    emp_emailbox.addEventListener('blur',EmpValidateEmail,true);
    emp_passbox.addEventListener('blur',EmpValidatePassword,true);

    function EmpValidateLogin() {
        if (EmpValidateEmail() && EmpValidatePassword()) {
            return true;
        }else {
            EmpValidatePassword();
            EmpValidateEmail();
            return false;
        }
    }
    function EmpValidateEmail(){
        if (emp_emailbox.value=='') {
            emp_user_error.textContent="This field can't be empty!";
            emp_emailbox.parentElement.style.borderBottom = "1px solid red";
            return false;
        }else {
            emp_user_error.textContent="";
            emp_emailbox.parentElement.style.borderBottom = "1px solid whitesmoke";
            return true;
        }
    }
    function EmpValidatePassword(){
        if (emp_passbox.value=='') {
            emp_login_error.textContent="This field can't be empty!";
            emp_passbox.parentElement.style.borderBottom = "1px solid red";
            return false;
        }else {
            emp_login_error.textContent="";
            emp_passbox.parentElement.style.borderBottom = "1px solid whitesmoke";
            return true;
        }
    }

    //OVO JE VALIDACIJA ZA KLIJENTA ISPOD
    var emailbox = document.forms['clogin']['email'];
    var passbox = document.forms['clogin'] ['password'];
    var login_error=document.getElementById('loginerror');
    var user_error=document.getElementById('usererror');
    var incorrect = "<?php echo $credential_error?>";
    var nouser= "<?php echo $not_existing?>";

    if (nouser) {
        user_error.textContent = "No existing user found!";
        emailbox.parentElement.style.borderBottom = "1px solid red";
    }

    if (incorrect){
        login_error.textContent="Incorrect password!";
        passbox.parentElement.style.borderBottom ="1px solid red";
    }

    emailbox.addEventListener('blur',ValidateEmail,true);
    passbox.addEventListener('blur',ValidatePassword,true);

    function ValidateLogin() {
    if (ValidateEmail() && ValidatePassword()) {
        return true;
    }else {
        ValidatePassword();
        ValidateEmail();
        return false;
    }
    }
    function ValidateEmail(){
        if (emailbox.value=='') {
            user_error.textContent="This field can't be empty!";
            emailbox.parentElement.style.borderBottom = "1px solid red";
            return false;
        }else {
            user_error.textContent="";
            emailbox.parentElement.style.borderBottom = "1px solid whitesmoke";
            return true;
        }
    }
    function ValidatePassword(){
        if (passbox.value=='') {
            login_error.textContent="This field can't be empty!";
            passbox.parentElement.style.borderBottom = "1px solid red";
            return false;
        }else {
            login_error.textContent="";
            passbox.parentElement.style.borderBottom = "1px solid whitesmoke";
            return true;
        }
    }
</script>


</body>
</html>




