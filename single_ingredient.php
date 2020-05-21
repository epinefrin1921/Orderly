<?php
include('includes/DB.php');

$id = $_GET['id'];

$query = oci_parse($conn, 'select * from INGREDIENTS where IN_ID ='. $id);
oci_execute($query);

$row = oci_fetch_assoc($query);

if (oci_num_rows($query) === 0) {
    header('Location: error.php');
}
$query2 = oci_parse($conn, 'select m.*, r.RL_QUANTITY
                            FROM INGREDIENTS i, RECIPE_LINE r, MENU_ITEMS m
                            where i.IN_ID=r.RL_INGREDIENT  and r.RL_MENU=m.MI_ID and r.RL_INGREDIENT='. $id);
oci_execute($query2);


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
            <a href="add_quantity_ingredient.php?id=<?= $row['IN_ID'] ?>">Add new quantity</a>
            <?php
            if($row['IN_DELETED']==null){
                ?>
                <a href="delete_ingredient.php?id=<?= $row['IN_ID']?>" onclick="return confirm('Are you sure you want to delete ingredient? All products and combos that contain this ingredient will be deleted!');">Delete ingredient</a>
                <?php
            };
            if($row['IN_DELETED']!=null){
                ?>
                <a href="activate_ingredient.php?id=<?= $row['IN_ID']?>" onclick="return confirm('Are you sure?');">Activate ingredient</a>

                <?php
            }?>
        </div>
    </div>

    <a href="storage.php">Back to ingredients</a>
    <?php if($row2=oci_fetch_assoc($query2)){
        oci_execute($query2);
        ?>
        <h1 style="text-align: center"> This ingredient is used in: </h1>
        <section class="wrap" id="s3" style="color: black; padding-top: 20px">
            <?php while($row2=oci_fetch_assoc($query2)):?>
                <div class="container">
                    <a href="single_product.php?id=<?= $row2['MI_ID'] ?>" class="info-more">
                        <img src="images/<?=$row2['MI_IMG']?>">
                        <p><?= $row2['MI_NAME'] ?></p>
                        <p>Price: <?= number_format($row2['MI_PRICE'],2)?>KM</p>
                        <p><?= number_format($row2['RL_QUANTITY'],2)?> is used</p>
                    </a>
                </div>
            <?php endwhile; ?>
        </section>
    <?php };?>
</main>
<?php include('includes/footer.php') ?>
</body>
</html>