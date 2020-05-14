<?php

include('includes/db.php');

$id = $_GET['id'];

$query = oci_parse($conn, 'select * from MENU_ITEMS where MENU_ITEMS.MI_ID = '. $id);
oci_execute($query);

$row = oci_fetch_assoc($query);

if (oci_num_rows($query) === 0) {
    die('Post is not found');
}

$title = $row['MI_NAME'];
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" href="styles/stil.css">
    <link rel="stylesheet" href="includes/products.css">
</head>

<body>
<?php include('includes/header.php') ?>

<h1><?= $row['MI_NAME'] ?></h1>
<h1><?= $row['MI_PRICE'] ?></h1>
<h1><?= $row['MI_DESCRIPTION'] ?></h1>
<h1><?= $row['MI_SUPPLY_PRICE'] ?></h1>


<?php include('includes/footer.php') ?>
</body>
</html>


