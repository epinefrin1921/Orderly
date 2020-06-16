<?php
session_start();
$title = 'Homepage';
include('includes/DB.php');

$query = oci_parse($conn, "select * from(select * from MENU_ITEMS where MI_DELETED is null and MI_TYPE='single' ORDER BY DBMS_RANDOM.RANDOM) where ROWNUM<5");
oci_execute($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles/stil.css">
    <?php include('includes/head.php') ?>
</head>
<style>
    ::-webkit-scrollbar {
        display: none;
    }
</style>
<body>
<?php include 'includes/header.php';?>
<div id="helping"></div>
<section class="wrap" id="s1">
    <div id="podnaslov">
        <?php

        $name=null;

        if (isset($_SESSION['id'])) {
           $name=", ".$_SESSION['user_first_name'];
        }
        ?>
        <h1>
            Feeling hungry<?=$name?>?
        </h1>
        <p>
            Order now and avoid waiting!
        </p>
    </div>
    <div class="slika" id="slika">
        <img src="1529573631.png">
    </div>
</section>

<section class="wrap" id="s2">
    <?php  if (isset($_SESSION['id'])) { ?>
        <a href="products/products/products.php">
            <button>Order Now</button>
        </a>
     <?php  }else { ?>
        <a href="validation/LogIn.php">
            <button>Order Now</button>
        </a>
     <?php }?>

</section>



<section class="wrap" id="s3">
    <section id="ss">
        <h3>We recommend:</h3>
    </section>
    <?php while($row=oci_fetch_assoc($query) ):?>
        <div class="container">
            <div class="container2">
                <form method="post" action="orders/addtocart.php?ID=<?php echo $row['MI_ID']; ?>">
                    <a href="products/products/single_product.php?id=<?= $row['MI_ID'] ?>" class="info-more">
                        <img src="images/<?=$row['MI_IMG']?>">
                        <p><?= $row['MI_NAME'] ?></p>
                        <p>Price: <?= number_format($row['MI_PRICE'],2)?>KM</p>
                    </a>
                    <?php if(isset($_SESSION['id']) and $_SESSION['type']==0){?>
                        <div class="cart-action"><label for="quantity">Quantity:</label> <input type="number" class="product-quantity" name="quantity" value="1" min="1"/><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
                    <?php } ?>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</section>

<section class="wrap" id="s4">
    <div>
        <h3>About</h3>
        <p><strong>orderly</strong> is an easy to use online reservation app made for SSST restaurant. It was develop by three SSST students.</p>
    </div>
    <div>
        <h3>Contact us</h3>
        <p>Want to contact SSST restaurant? <br> Call us on: +387603094532<br> or send us an email: <br> restaurant@ssst.edu.ba</p>
    </div>
    <div>
        <h3>How to order</h3>
        <p><strong>orderly</strong> is simple to use. Register, order and enjoy your meal without waiting!
            No need to wait for Maca to show up.</p>
    </div>
</section>
<?php
include 'includes/footer.php'; ?>

</body>
</html>