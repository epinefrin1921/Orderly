<?php
$sender = 'nedim.ajdin1@gmail.com';
$recipient = 'nedim.ajdin@stu.ssst.edu.ba';

$subject = "php mail test";
$message = "php test message";
$headers = 'From:' . $sender;

if (mail($recipient, $subject, $message, $headers))
{
    echo "Message accepted";
}
else
{
    echo "Error: Message not accepted";
}
?>