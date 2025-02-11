<?php

require_once '../sanitize.php';
require_once '../classes/account.class.php';

session_start();

$accountObj = new Account();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $accountObj->verifyEmail($token);

    header('Location: http://localhost/hubvenue/index.php');
    exit();
}

?>