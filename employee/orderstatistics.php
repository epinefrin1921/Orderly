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

        $query = oci_parse($conn, "select * from ORDERS where O_DATE_RECEIVED>to_date('{$start}','YYYY-MM-DD') and O_DATE_RECEIVED<to_date('{$end}','YYYY-MM-DD') ");
        oci_execute($query);
        $totalamount=0;
        $number=0;
        while($row=oci_fetch_assoc($query)){
            $totalamount=$totalamount+$row['O_TOTAL_AMOUNT'];
            $number=$number+1;
        };
        $start = date('d.m.Y', strtotime($start));
        $end = date('d.m.Y', strtotime($end));
    }
}
$title='Financial results';

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
    <form action="finance.php" method="post">
        <label for="start">Start date</label>
        <input type="date" id="start" name="start">
        <label for="end">End date</label>
        <input type="date" id="end" name="end">
        <input type="submit">
    </form>
</div>





<?php include '../includes/footer.php'; ?>

</body>
</html>