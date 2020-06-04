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

        $query = oci_parse($conn, "select e.E_FNAME, e.E_LNAME, e.E_ID, max(o.O_TOTAL_AMOUNT) as max, min(o.O_TOTAL_AMOUNT) as min, avg(o.O_TOTAL_AMOUNT) as avg, count(distinct o.O_ID) as cnt, sum(o.O_TOTAL_AMOUNT) as sum
        FROM EMPLOYEE e, ORDERS o
        where o.O_EMPLOYEE=e.E_ID and O_DATE_RECEIVED>to_date('{$start}','YYYY-MM-DD') and O_DATE_RECEIVED<to_date('{$end}','YYYY-MM-DD') 
        group by e.E_FNAME, e.E_LNAME, e.E_ID");
        oci_execute($query);
        $found=true;


        $start = date('Y-m-d', strtotime($_POST['start']));
        $end = date('Y-m-d', strtotime($_POST['end']));
    }
}

$title='Employee statistics';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles/stil.css">
    <link rel="stylesheet" href="../styles/empstat.css">
    <?php include('../includes/head.php') ?>
</head>

<body>
<?php include '../includes/header.php';?>
<div id="helping"></div>
<div id="empstaty">
    <form action="employeestatistics.php" method="post">
        <label for="start"  style="color:white;">Start date</label>
        <input type="date" id="start" name="start">
        <label for="end"  style="color:white; margin-left:10px;">End date</label>
        <input type="date" id="end" name="end">
        <div id="empy"><input type="submit" style="width: 30%"></div>
    </form>
</div>
<?php if($_POST and $found):?>
    <h3 style="color: white;text-align: center;">Period: <?=$start?> to <?=$end?>, excluding last day</h3>

    <div class="prikaz" style="width: 80%;margin:30px auto;">
        <div style="text-align: center; color:white;">
        <h1>Waiter statistics: </h1>
        <?php while($row=oci_fetch_assoc($query)): ?>
        <div id="dim">
            <h3>Name: <?= $row['E_FNAME']." ".$row['E_LNAME'] ?></h3>
            <h4>Total orders delivered in that period: <?=$row['CNT']?></h4>
            <h4>Highest paid order delivered in that period: <?=$row['MAX']?>KM</h4>
            <h4>Minimum paid order in that period: <?=$row['MIN']?>KM</h4>
            <h4>Average order paid in that period: <?=number_format($row['AVG'], 2)?>KM</h4>
            <h4>Total amount generated in that period: <?=$row['SUM']?>KM</h4>
            <?php
            $query3 = oci_parse($conn, "select o.O_ID, e.E_FNAME, e.E_LNAME ,TO_CHAR(max(OH_TIME_CHANGED), 'YYYY-MM-DD HH24:MI:SS') as max, TO_CHAR(min(OH_TIME_CHANGED), 'YYYY-MM-DD HH24:MI:SS') as min
                        from orders_history oh, orders o, employee e
                        where OH_ORDER=o.O_ID and o.O_EMPLOYEE=e.E_ID and o.O_EMPLOYEE={$row['E_ID']} and O_DATE_RECEIVED>to_date('{$start}','YYYY-MM-DD') and O_DATE_RECEIVED<to_date('{$end}','YYYY-MM-DD') and o.O_STATUS='finished'
                        group by o.O_ID, E_FNAME, E_LNAME");

            oci_execute($query3);
            $i=0;
            $totaltime=0;

            $hours=0;
            $minutes=0;

            while($row7=oci_fetch_assoc($query3)){
                $time1=date('d.m.Y H:i:s', strtotime($row7['MAX']));
                $time2=date('d.m.Y H:i:s', strtotime($row7['MIN']));
                $time3=abs(strtotime($time1)-strtotime($time2));
                $totaltime=$totaltime+$time3;
                $i++;
            }
            $totaltime=$totaltime/$i;

            $minutes=$totaltime/60;

            if(!floor($minutes/60)==NAN){
                $hours=floor($minutes/60);
            }
            $minutes2=$minutes%60;
            ?>
            <h4 style="text-align: center;color: white;">Average waiting time in that period: <?= $hours!=0? $hours.' hours and': null ?> <?=$minutes2?> minutes</h4>
        </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>



<?php include '../includes/footer.php'; ?>

</body>
</html>