<?php
$title = 'Products';
include('includes/DB.php');

 $query = oci_parse($conn, "select * from MENU_ITEMS where lower(MI_TYPE)='single'");

$query2 = oci_parse($conn, "select * from MENU_ITEMS where lower(MI_TYPE)='combo'");

 oci_execute($query);
oci_execute($query2);


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
    <p><a href="new_product.php">Add new product</a> </p>

    <h1 id="naslov3">Products:</h1>
</div>

<section class="wrap" id="s3">
<?php while($row=oci_fetch_assoc($query)):?>
    <div class="container">
    <a href="single_product.php?id=<?= $row['MI_ID'] ?>" class="info-more">
        <div class="container2">
            <img src="<?=$row['MI_IMG']?>">
            <p><?= $row['MI_NAME'] ?></p>
            <p>Price: <?= number_format($row['MI_PRICE'],2)?>KM</p>
            <button>Add to Cart</button>
        </div>
    </a>
    </div>
<?php endwhile; ?>
</section>

<div class="wrap2 jumbotron">
    <p><a href="new_combo.php">Add new combo</a> </p>

    <h1 id="naslov3">Combos:</h1>
</div>

<section class="wrap" id="s3">
    <?php while($row=oci_fetch_assoc($query2)):?>
        <div class="container">
            <a href="single_combo.php?id=<?= $row['MI_ID'] ?>" class="info-more">
                <div class="container2">
                    <img src="<?=$row['MI_IMG']?>">
                    <p><?= $row['MI_NAME'] ?></p>
                    <p>Price: <?= number_format($row['MI_PRICE'],2)?>KM</p>
                    <button>Add to Cart</button>
                </div>
        </div>
    <?php endwhile; ?>
</section>

<?php include('includes/footer.php') ?>
</body>
</html>
