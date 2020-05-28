<?php
include('../../includes/DB.php');

session_start();

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}

$id = $_GET['id'];

if(checkRequiredField($id)){
    $query = oci_parse($conn, 'select * from MENU_ITEMS where MENU_ITEMS.MI_ID = '. $id);
    oci_execute($query);

    $row = oci_fetch_assoc($query);

    $query2 = oci_parse($conn, 'select m.*, pl.* from MENU_ITEMS m, PACKAGE_LINE pl where m.MI_ID=pl.PL_CHILD_ID and pl.PL_FATHER_ID= '.$id);
    oci_execute($query2);

}
else{
    header('Location: ../../error.php');
}

$title = $row['MI_NAME'];
?>
<!doctype html>
<html lang="en">
<head>
    <?php include('../../includes/head.php') ?>
    <link rel="stylesheet" href="../../styles/stil.css">
    <link rel="stylesheet" href="../../styles/productsingle.css">
</head>

<body>
<?php include('../../includes/header.php') ?>
<main class="wrap">
    <div class="prikaz">
        <div class="info">
            <h2><?= $row['MI_NAME'] ?></h2>
            <p>Price: <?= $row['MI_PRICE'] ?>KM</p>
            <p>Description: <?= $row['MI_DESCRIPTION'] ?></p>
            <p>You save <?=  number_format($row['MI_SUPPLY_PRICE']-$row['MI_PRICE'],2) ?>KM if you buy this combo! </p>

            <?php
            if (isset($_SESSION['id']) and $_SESSION['type']==1):?>

                <p>Date added: <?= date("d.m.Y", strtotime($row['MI_CREATED'])) ?></p>

                <?php
                 if($row['MI_DELETED']!=null):
                ?>
                <p>Date deleted: <?= date("d.m.Y", strtotime($row['MI_DELETED'])) ?></p>
                 <?php endif;?>

                <a href="edit_combo.php?id=<?= $row['MI_ID'] ?>">Edit combo </a>
                <?php
                if($row['MI_DELETED']==null){
                    ?>
                    <a href="delete_combo.php?id=<?= $row['MI_ID']?>" onclick="return confirm('Are you sure?');">Delete combo</a>
                    <?php
                };
                if($row['MI_DELETED']!=null){
                    ?>
                    <a href="activate_combo.php?id=<?= $row['MI_ID']?>" onclick="return confirm('Are you sure?');">Activate combo</a>

                    <?php
                }?>

            <?php endif;?>

        </div>
        <img src="../../images/<?=$row['MI_IMG']?>">
    </div>
<h1 style="text-align: center"> Combo includes: </h1>
<section class="wrap" id="s3" style="color: black; padding-top: 20px">
    <?php while($row=oci_fetch_assoc($query2)):?>
        <div class="container">
            <a href="../products/single_product.php?id=<?= $row[0] ?>" class="info-more">
                <img src="../../images/<?=$row[4]?>">

            <p><?= $row['MI_NAME'] ?></p>
            <p>Price: <?= number_format($row[1],2)?>KM</p>
            </a>
        </div>
    <?php endwhile; ?>
</section>
</main>
<?php include('../../includes/footer.php') ?>
</body>
</html>