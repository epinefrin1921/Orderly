<?php

$title = 'Products';
include('includes/DB.php');

$query = oci_parse($conn, "select * from INGREDIENTS");

oci_execute($query);
?>

<!doctype html>
<html lang="en">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" href="styles/stil.css">
    <link rel="stylesheet" href="styles/products.css">
</head>

<body>
<?php include('includes/header.php') ?>
<div class="wrap2 jumbotron">
    <p><a href="new_ingredient.php">Add new ingredient</a> </p>

    <h1 id="naslov3">Ingredients:</h1>
</div>

<section class="wrap" id="s3">
    <?php while($row=oci_fetch_assoc($query)):?>
        <div class="container">
            <a href="single_ingredient.php?id=<?= $row['IN_ID'] ?>" class="info-more">
                <div class="container2">
                    <p><strong><?= $row['IN_NAME'] ?></strong></p>
                    <p>On stock: <?= number_format($row['IN_QUANTITY'],2)?></p>

                    <p>Price per unit: <?= number_format($row['IN_PRICE'],2)?>KM</p>
                </div>
            </a>
        </div>
    <?php endwhile; ?>
</section>


<?php include('includes/footer.php') ?>
</body>
</html>
