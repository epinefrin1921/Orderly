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

    $query = oci_parse($conn, "INSERT INTO TESTS(T_FNAME, T_LNAME, T_EMAIL, T_PHONE, T_DATE, T_RESULT)
                       VALUES ('{$fname}','{$lname}', '{$email}', '{$phone}', sysdate, 1)");
    oci_execute($query);
    oci_commit($conn);

    $query2 = oci_parse($conn, "select * from visits where V_DATE > (sysdate - 3)");
    oci_execute($query2);
    while ($row = oci_fetch_assoc($query2)) {
        $query3 = oci_parse($conn, "insert into NOTIFICATIONS (N_CID, N_VISITID) values ({$row['V_CID']},{$row['V_ID']})");
        oci_execute($query3);
        oci_commit($conn);
    }

    header('Location: thankyou.php');
}