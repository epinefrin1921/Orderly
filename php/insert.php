<?php
$Fname=$_POST['FName'];
$Lname=$_POST['LName'];
$DOB=$_POST['DOB'];
$Email=$_POST['Email'];
$Password=$_POST['Password'];
$ConfirmPassword=$_POST['ConfirmPassword'];

if (!empty($Fname) || !empty($Lname) || !empty($DOB) || !empty($Email) || !empty($Password) || !empty($ConfirmPassword)) {
    $host='localhost'; $username='root'; $dbpass=''; $dbname='project';
    $con = new mysqli($host,$username,$dbpass,$dbname);
    if (mysqli_connect_error()) {
        die("Connect Error(" .mysqli_connect_errno() .")".mysqli_connect_error());
    } else {
        if ($ConfirmPassword == $Password) {
            $select = "SELECT Email FROM users WHERE Email=? Limit 1";
            $insert = "INSERT INTO users (Fname,Lname,Email,DOB,Password) values (?,?,?,?,?)";
            $stmt = $con->prepare($select);
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $stmt->bind_result($Email);
            $stmt->store_result();
            $r = $stmt->num_rows;
            if ($r == 0) {
                $stmt->close();
                $stmt = $con->prepare($insert);
                $stmt->bind_param("sssss", $Fname, $Lname, $Email, $DOB, $Password);
                $stmt->execute();
                echo "New record added sucessfully";

            } else {
                echo "Account already exists!";
            }
            $stmt->close();
            $con->close();
        } else{
            echo "Passwords do not match!";

        } }
    } else {
    echo "All fields are required!";

    die();
}


?>