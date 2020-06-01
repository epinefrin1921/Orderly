<?php
$to      = 'nedim.ajdin1@gmail.com';
$subject = 'Test';
$message = 'hello test 123';
$headers = 'From: Orderly' . "\r\n" .
    'Reply-To: nedim.ajdin@stu.ssst.edu.ba' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>