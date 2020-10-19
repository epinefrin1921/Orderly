<?php

include('../includes/DB.php');

session_start();

function checkRequiredField($value)
{
    return isset($value) && !empty($value);
}

if ($_POST) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = oci_parse($conn, "INSERT INTO TESTS(T_ID, T_FNAME, T_LNAME, T_EMAIL, T_PHONE, T_DATE, T_RESULT)
                       VALUES (10,'{$fname}','{$lname}', '{$email}', '{$phone}', sysdate, 1)");
    oci_execute($query);
    oci_commit($conn);

    $query2 = oci_parse($conn, "select * from VISITS where V_DATE > (sysdate - 3)");
    oci_execute($query2);
    $i=1;
    while ($row = oci_fetch_assoc($query2)) {
        $query3 = oci_parse($conn, "insert into NOTIFICATIONS (N_ID, N_CID, N_VISITID) values ({$i},{$row['V_CID']},{$row['V_ID']})");
        oci_execute($query3);
        oci_commit($conn);
        $i++;
    }

    header('Location: thankyou.php');
}