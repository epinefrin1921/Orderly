<?php

include  '../includes/DB.php';
$e=$_REQUEST["e"];

$query=oci_parse($conn,"select * from CLIENT where C_EMAIL = '{$e}'");

oci_execute($query);

$row = oci_fetch_assoc($query);
if ($row) {
    echo "exists";
} else {
    echo "not";
}
?>

