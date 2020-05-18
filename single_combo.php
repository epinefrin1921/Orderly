<?php
include('includes/DB.php');

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}

$id = $_GET['id'];

if(checkRequiredField($id)){
    $query = oci_parse($conn, 'select * from MENU_ITEMS where MENU_ITEMS.MI_ID = '. $id);
    oci_execute($query);

    $query2 = oci_parse($conn, 'select P.*, M.* from PACKAGE_LINE P ,MENU_ITEMS M where P.PL_CHILD_ID = MI_ID AND P.PL_FATHER_ID = '. $id);
    oci_execute($query2);

    $total=0;

    while($row3=oci_fetch_assoc($query2)){
        $total=$total+$row3['MI_PRICE'];
    };


    oci_execute($query2);


    $row = oci_fetch_assoc($query);
}
else{
    header('Location: error.php');
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
            <p>You save <?=  number_format($total-$row['MI_PRICE'],2) ?>KM if you buy this combo! </p>
            <a href="edit_combo.php?id=<?= $row['MI_ID'] ?>">Edit combo </a>
            <a href="delete_combo.php?id=<?= $row['MI_ID']?>">Delete combo</a>
        </div>
        <img src="<?=$row['MI_IMG']?>">
    </div>
<h1 style="text-align: center"> Combo includes: </h1>
<section class="wrap" id="s3" style="color: black; padding-top: 20px">
    <?php while($row=oci_fetch_assoc($query2)):?>
        <div class="container">
            <a href="single_product.php?id=<?= $row['MI_ID'] ?>" class="info-more">
            <img src="<?=$row['MI_IMG']?>">
            <p><?= $row['MI_NAME'] ?></p>
            <p>Price: <?= number_format($row['MI_PRICE'],2)?>KM</p>
            </a>
        </div>
    <?php endwhile; ?>
</section>
</main>
<?php include('includes/footer.php') ?>
</body>
</html>