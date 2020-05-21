<?php
session_start();

include('includes/DB.php');
$_SESSION = [];
session_destroy();

header('Location: index.php');