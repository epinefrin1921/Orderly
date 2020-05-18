<?php

include('includes/DB.php');

$id = $_GET['id'];

$query = oci_parse($conn, 'select * from MENU_ITEMS where MENU_ITEMS.MI_ID = '. $id);
oci_execute($query);

$row = oci_fetch_assoc($query);

$query2 = oci_parse($conn, 'select i.IN_NAME, r.RL_QUANTITY
                                   FROM INGREDIENTS i, RECIPE_LINE r, MENU_ITEMS m
                                   where i.IN_ID = r.RL_INGREDIENT and m.MI_ID=r.RL_MENU and r.RL_MENU='. $id);
oci_execute($query2);


$query3 = oci_parse($conn, 'select distinct m.*
FROM PACKAGE_LINE p, MENU_ITEMS m
where p.PL_FATHER_ID=m.MI_ID and p.PL_CHILD_ID='.$id);
oci_execute($query3);



if (oci_num_rows($query) === 0) {
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
            <a href="edit_product.php?id=<?= $row['MI_ID'] ?>">Edit product </a>
            <a href="delete_product.php?id=<?= $row['MI_ID']?>">Delete product</a>
        </div>
        <img src="<?=$row['MI_IMG']?>">
    </div>
    <?php if($row2=oci_fetch_assoc($query2)){
    oci_execute($query2);
    $row2 = oci_fetch_assoc($query);
    ?>
    <h1 style="text-align: center"> Ingredients: </h1>
    <section class="wrap" id="s3" style="color: black; padding-top: 20px">
        <?php while($row2=oci_fetch_assoc($query2)):?>
            <div class="container" style="color: #89253e">
                <p><?= $row2['IN_NAME']?></p>
                <p>Quantity: <?= number_format($row2['RL_QUANTITY'],2)?></p>
            </div>
        <?php endwhile; ?>
    </section>
    <?php };?>

    <?php if($row3=oci_fetch_assoc($query3)){
        oci_execute($query3);
        $row3 = oci_fetch_assoc($query);
        ?>
    <h1 style="text-align: center"><?= $row['MI_NAME'] ?>  in combos: </h1>
    <section class="wrap" id="s3" style="color: black; padding-top: 20px">
        <?php while($row3=oci_fetch_assoc($query3)):?>
            <div class="container">
                <a href="single_combo.php?id=<?= $row3['MI_ID'] ?>" class="info-more">
                    <div class="container2" >
                        <img src="<?=$row3['MI_IMG']?>">
                        <p><?= $row3['MI_NAME'] ?></p>
                        <p>Price: <?= number_format($row3['MI_PRICE'],2)?>KM</p>
                        <button>Add to Cart</button>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </section>
    <?php };?>
</main>
<?php include('includes/footer.php') ?>
</body>
</html>

