<?php
include('../includes/DB.php');
session_start();

function checkRequiredField ($value) {
    return isset($value) && !empty($value);
}

if(!isset($_SESSION['id'])){
    header('Location: ../index.php');
    exit();
}
if($_SESSION['type']==0){
    header('Location: ../index.php');
    exit();
}

if($_POST) {
    if (checkRequiredField($_POST['start']) and checkRequiredField($_POST['end'])) {
        $start = date('Y-m-d', strtotime($_POST['start']));
        $end = date('Y-m-d', strtotime($_POST['end']));

        if ($start > $end) {
            header('Location: ../error.php');
            exit();
        }

        $query = oci_parse($conn, "select e.E_FNAME, e.E_LNAME, max(o.O_TOTAL_AMOUNT) as max, min(o.O_TOTAL_AMOUNT) as min, avg(o.O_TOTAL_AMOUNT) as avg, count(distinct o.O_ID) as cnt, sum(o.O_TOTAL_AMOUNT) as sum
        FROM EMPLOYEE e, ORDERS o
        where o.O_EMPLOYEE=e.E_ID and O_DATE_RECEIVED>to_date('{$start}','YYYY-MM-DD') and O_DATE_RECEIVED<to_date('{$end}','YYYY-MM-DD') 
        group by e.E_FNAME, e.E_LNAME");
        oci_execute($query);
        $found=true;

        $start = date('d.m.Y', strtotime($start));
        $end = date('d.m.Y', strtotime($end));
    }
}

$title='Employee statistics';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles/stil.css">
    <?php include('../includes/head.php') ?>
</head>

<body>
<?php include '../includes/header.php';?>
<div id="helping"></div>
<div>
    <form action="employeestatistics.php" method="post">
        <label for="start">Start date</label>
        <input type="date" id="start" name="start">
        <label for="end">End date</label>
        <input type="date" id="end" name="end">
        <input type="submit">
    </form>
</div>
<?php if($_POST and $found):?>
    <h3>Period: <?=$start?> to <?=$end?>, excluding last day</h3>

<div>
    <h1>Waiter statistics: </h1>
    <?php while($row=oci_fetch_assoc($query)): ?>
    <h3>Name: <?= $row['E_FNAME']." ".$row['E_LNAME'] ?></h3>
    <h4>Total orders delivered in that period: <?=$row['CNT']?></h4>
        <h4>Highest paid order delivered in that period: <?=$row['MAX']?></h4>
        <h4>Minimum paid order in that period: <?=$row['MIN']?></h4>
        <h4>Average order paid in that period: <?=$row['AVG']?></h4>
        <h4>Total amount generated in that period: <?=$row['SUM']?></h4>
    <?php endwhile; ?>
</div>
<?php endif; ?>



<?php include '../includes/footer.php'; ?>

</body>
</html>