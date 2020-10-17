<?php
$title = 'Products';
include('../../includes/DB.php');

session_start();
if(!isset($_SESSION['id'])){
    header('Location: ../../index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: ../../index.php');
    exit();
}

$query = oci_parse($conn, "select * from MENU_ITEMS where MI_DELETED is not null and lower(MI_TYPE)!='combo'");

$query2 = oci_parse($conn, "select * from MENU_ITEMS where MI_DELETED is not null and lower(MI_TYPE)='combo'");

oci_execute($query);
oci_execute($query2);


?>

<!doctype html>
<html lang="en">
<head>
    <?php include('../../includes/head.php') ?>
    <link rel="stylesheet" href="../../styles/stil.css">
    <link rel="stylesheet" href="../../styles/products.css">
</head>

<body>
<?php include('../../includes/header.php') ?>
<div id="helping"></div>

<div class="wrap2 jumbotron">
    <p><a href="new_product.php">Add new product</a> </p>
    <p><a href="../combos/new_combo.php">Add new combo</a> </p>
    <p><a href="../ingredients/storage.php">Open storage</a></p>
    <p><a href="products.php">Open active products and combos</a></p>
    <h1 id="naslov3">Products:</h1>
</div>

<section class="wrap" id="s3">
    <?php while($row=oci_fetch_assoc($query)):?>
        <div class="container">
            <a href="single_product.php?id=<?= $row['MI_ID'] ?>" class="info-more">
                <div class="container2">
                    <img src="../../images/<?=$row['MI_IMG']?>">
                    <p><?= $row['MI_NAME'] ?></p>
                    <p>Price: <?= number_format($row['MI_PRICE'],2)?>KM</p>
                </div>
            </a>
        </div>
    <?php endwhile; ?>
</section>

<div class="wrap2 jumbotron">
    <h1 id="naslov3">Combos:</h1>
</div>

<section class="wrap" id="s3">
    <?php while($row=oci_fetch_assoc($query2)):?>
        <?php

        $query3 = oci_parse($conn, 'select P.*, M.* from PACKAGE_LINE P ,MENU_ITEMS M where P.PL_CHILD_ID = MI_ID  AND P.PL_FATHER_ID = '. $row['MI_ID']);
        oci_execute($query3);

        $total=0;

        while($row4=oci_fetch_assoc($query3)){
            $total=$total+$row4['MI_PRICE'];
        };

        ?>

        <div class="container">
            <a href="../combos/single_combo.php?id=<?= $row['MI_ID'] ?>" class="info-more">
                <div class="container2">
                    <img src="../../images/<?=$row['MI_IMG']?>">
                    <p><?= $row['MI_NAME'] ?></p>
                    <p>Price: <?= number_format($row['MI_PRICE'],2)?>KM</p>
                    <p>You save <?=number_format($total-$row['MI_PRICE'],2) ?>KM </p>
                </div>
            </a>
        </div>
    <?php endwhile; ?>
</section>

<?php include('../../includes/footer.php') ?>
</body>
</html>