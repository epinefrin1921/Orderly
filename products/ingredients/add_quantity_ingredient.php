
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
$title = 'Edit ingredient';
function checkRequiredField ($value)
{
    return isset($value) && !empty($value);
}
$id = $_GET['id'];
if(checkRequiredField($id)){
    $query = oci_parse($conn, 'select * from INGREDIENTS where IN_ID = ' . $id);
    oci_execute($query);
    $row = oci_fetch_assoc($query);
}
else{
    header('Location: ../../error.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('../../includes/head.php') ?>
    <link rel="stylesheet" href="../../styles/stil.css">
    <link rel="stylesheet" href="../../styles/products.css">
    <link rel="stylesheet" href="../../styles/LogInStil.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
<h1><a href="../../index.php">Welcome to orderly</a></h1>
<form class="Login" action="update_ingredient2.php" method="POST" >
    <h2>Add new quantity to <?= $row['IN_NAME'] ?> (in the storage right now: <?= $row['IN_QUANTITY'] ?>)</h2>

    <input type="hidden" name="id" value="<?= $id ?>">
    <div class="textbox">
        <label for="quantity">Ingredient quantity:</label>
        <input type="number" placeholder="Ingredient quantity" name="quantity" value="" min="0" required step="0.01">
    </div>
    <input class="butt" type="submit" name="" value="Edit ingredient to database">

</form>

</body>
</html>
