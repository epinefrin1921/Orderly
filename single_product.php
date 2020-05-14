<?php

include('includes/DB.php');

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
    <link rel="stylesheet" href="styles/productsingle.css">
</head>

<body>
<?php include('includes/header.php') ?>
<main class="wrap">
    <div class="prikaz">
        <div class="info">
            <h2><?= $row['MI_NAME'] ?></h2>
            <p>Price: <?= $row['MI_PRICE'] ?>KM</p>
            <p>Description: <?= $row['MI_DESCRIPTION'] ?></p>
            <a href="edit_product.php?id=<?= $row['MI_ID'] ?>">Edit product </a>
            <a href="delete_product.php?id=<?= $row['MI_ID']?>">Delete product</a>
        </div>
        <img src="<?=$row['MI_IMG']?>">
    </div>
</main>
<?php include('includes/footer.php') ?>
</body>
</html>


