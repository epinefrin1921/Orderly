<?php
include('includes/DB.php');

$id = $_GET['id'];

$query = oci_parse($conn, 'select * from INGREDIENTS where IN_ID ='. $id);
oci_execute($query);

$row = oci_fetch_assoc($query);

if (oci_num_rows($query) === 0) {
    die('Post is not found');
}

$title = $row['IN_NAME'];
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
            <h2><?= $row['IN_NAME'] ?></h2>
            <p>Quantity: <?= $row['IN_QUANTITY'] ?></p>
            <p>Price: <?= $row['IN_PRICE'] ?>KM</p>
            <a href="edit_ingredient.php?id=<?= $row['IN_ID'] ?>">Edit ingredient </a>
            <a href="delete_ingredient.php?id=<?= $row['IN_ID']?>">Delete ingredient</a>
        </div>
    </div>
</main>
<?php include('includes/footer.php') ?>
</body>
</html>