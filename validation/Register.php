<?php
session_start();

if(isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}

$title = 'Register';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('../includes/head.php') ?>
    <link rel="stylesheet" href="../styles/RegStil.css">
</head>
<body>
<h1><a href="../index.php">Welcome to orderly</a></h1>
<?php
$today = date("Y-m-d");
?>
<form class="Login" action="../clients/save_user.php" onsubmit="return Validate()" method="post"  name="regform"  enctype="multipart/form-data">
    <h2>Register</h2>
    <div class="textbox">
        <input type="text" placeholder="Name" name="fname" value="" >
    </div>
    <div id="fname_error" class="erroneus"></div>
    <div class="textbox">
        <input type="text" placeholder="Surname" name="lname" value="" >
    </div>
    <div id="lname_error" class="erroneus"></div>
    <div class="textbox" id="date1">
        <input type="date" placeholder="Date of Birth" name="DOB" value="" min="1900-01-01" max="<?php echo $today?>" >
    </div>
    <div class="textbox">
        <label for="image">Profile image:</label>
        <input type="file" placeholder="Profile image" id="image" name="image" required>
    </div>
    <div id="dob_error" class="erroneus"></div>
    <div class="textbox">
        <input type="text" placeholder="E-mail" name="email" value="" >
    </div>
    <div id="email_error" class="erroneus"></div>
    <div class="textbox">
        <input type="password" placeholder="New Password (8-32 characters)" name="password" value="" >
    </div>
    <div id="password_error" class="erroneus"></div>
    <div class="textbox">
        <input type="password" placeholder="Confirm Password" name="confirmpassword" value=""  >
    </div>
    <div id="confirm_error" class="erroneus"></div>
    <input class="butt" type="submit" name="" value="Submit" >
</form>


<script type="text/javascript">
    var fname=document.forms['regform']['fname'];
    var fname_error=document.getElementById('fname_error');

    var lname=document.forms['regform']['lname'];
    var lname_error=document.getElementById('lname_error');

    var dob=document.forms['regform']['DOB'];
    var dob_error=document.getElementById('dob_error');

    var email=document.forms['regform']['email'];
    var email_error=document.getElementById('email_error');

    var password=document.forms['regform']['password'];
    var password_error=document.getElementById('password_error');

    var confirmpassword=document.forms['regform']['confirmpassword'];
    var confirm_error=document.getElementById('confirm_error');


    fname.addEventListener('blur',fnameValidate,true);
    lname.addEventListener('blur',lnameValidate,true);
    dob.addEventListener('blur',dobValidate,true);
    email.addEventListener('blur',emailValidate,true);
    password.addEventListener('blur',passwordValidate,true);
    confirmpassword.addEventListener('blur',confirmValidate,true);



    function Validate() {
        if (fnameValidate() && lnameValidate() && dobValidate() && emailValidate() && passwordValidate() && confirmValidate()) {
            return true
        } else {
            fnameValidate();
            lnameValidate();
            dobValidate();
            emailValidate();
            passwordValidate();
            confirmValidate();
            return false;
        }
    }

    function fnameValidate() {
        if (fname.value == "") {
            fname_error.textContent="Name field can't be empty!";
            fname.parentElement.style.borderBottom ="1px solid red";
            return false;
        } else if (fname.value.length <2) {
            fname_error.textContent="Name must be at least 2 letters long!";
            fname.parentElement.style.borderBottom ="1px solid red";
            return false;
        } else if (hasSpaces(fname.value)) {
            fname_error.textContent="Name can contain no spaces!";
            fname.parentElement.style.borderBottom ="1px solid red";
            return false;
        } else if (hasNumbers(fname.value)) {
            fname_error.textContent="Name must not contain numbers!";
            fname.parentElement.style.borderBottom ="1px solid red";
            return false;
        }
        else {
            fname.parentElement.style.borderBottom ="1px solid whitesmoke";
            fname_error.innerHTML="";
            return true;
        }
    }

    function lnameValidate() {
        if (lname.value == "") {
            lname_error.textContent = "Surname field can't be empty!";
            lname.parentElement.style.borderBottom = "1px solid red";
            return false;
        } else if (lname.value.length < 2) {
            lname_error.textContent = "Surname must be at least 2 letters long!";
            lname.parentElement.style.borderBottom = "1px solid red";
            return false;
        } else if (hasSpaces(lname.value)) {
            lname_error.textContent = "Surname can contain no spaces!";
            lname.parentElement.style.borderBottom = "1px solid red";
            return false;
        } else if (hasNumbers(lname.value)) {
            lname_error.textContent = "Surname must not contain numbers!";
            lname.parentElement.style.borderBottom = "1px solid red";
            return false;
        } else {
            lname.parentElement.style.borderBottom = "1px solid whitesmoke";
            lname_error.innerHTML = "";
            return true;
        }
    }

    function dobValidate() {
        var datum = new Date();

        if(dob.value<"1900-01-01" || new Date(dob.value)>datum) {
            dob_error.textContent="Please select a valid date!";
            dob.parentElement.style.borderBottom = "1px solid red";
            return false;
        }else {
            dob_error.innerHTML="";
            dob.parentElement.style.borderBottom = "1px solid whitesmoke";
            return true;
        }
    }

    function emailValidate(){
        if (email.value=="") {
            email_error.textContent="E-mail field can't be empty!";
            email.parentElement.style.borderBottom="1px solid red";
            return false;
        } else if(!emailFormatTest(email.value)) {
            email_error.textContent="The entered e-mail is invalid!";
            email.parentElement.style.borderBottom="1px solid red";
            return false;
        }
        else {
            email.parentElement.style.borderBottom = "1px solid whitesmoke";
            email_error.innerHTML = "";
            return true;
        }
    }

    function passwordValidate(){
        if (password.value==""){
            password_error.textContent="Password field can't be empty!";
            password.parentElement.style.borderBottom="1px solid red";
            return false;
        } else if (hasSpaces(password.value)) {
            password_error.textContent="Password can't contain spaces!";
            password.parentElement.style.borderBottom="1px solid red";
            return false;
        } else if (!passwordFormatTest(password.value)) {
            password_error.textContent="Invalid Password!";
            password.parentElement.style.borderBottom="1px solid red";
            return false;
        } else {
            password_error.innerHTML="";
            password.parentElement.style.borderBottom="1px solid whitesmoke";
            return true;
        }
    }

    function confirmValidate() {
        if (password.value=="") {
            confirm_error.textContent="No password was entered!";
            confirmpassword.parentElement.style.borderBottom="1px solid red";
            return false;
        } else if (confirmpassword.value != password.value) {
            confirm_error.textContent="Passwords do not match";
            confirmpassword.parentElement.style.borderBottom="1px solid red";
            return false;
        } else {
            confirm_error.textContent="Passwords Match!";
            confirm_error.style.color="green";
            confirmpassword.parentElement.style.borderBottom="1px solid whitesmoke";
            return true;
        }
    }

    function hasSpaces(phrase) {
        return /\s/g.test(phrase);
    }
    function hasNumbers(phrase) {
        return /\d/.test(phrase);
    }
    function emailFormatTest(myEmail){
        var mailKey = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        return mailKey.test(myEmail);
    }
    function passwordFormatTest(myPassword){
        var passKey= /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}$/;
        return passKey.test(myPassword);
    }


</script>


</body>
</html>