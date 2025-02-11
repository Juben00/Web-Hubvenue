<?php
require_once(__DIR__ . '/../classes/account.class.php');

$accountObj = new Account();

$token = $newpass = $newpassErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newpass = $_POST['newpass'];

    if (empty($newpass)) {
        $newpassErr = "New password is required";
    } elseif (strlen($newpass) < 8) {
        $newpassErr = "Password must be at least 8 characters";
    } elseif (!preg_match("#[0-9]+#", $newpass)) {
        $newpassErr = "Password must contain at least one number";
    } elseif (!preg_match("#[A-Z]+#", $newpass)) {
        $newpassErr = "Password must contain at least one uppercase letter";
    } elseif (!preg_match("#[a-z]+#", $newpass)) {
        $newpassErr = "Password must contain at least one lowercase letter";
    }

    if (empty($newpassErr)) {
        $result = $accountObj->resetUserPassword($token, $newpass);
        echo json_encode($result);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => $newpassErr]);
    }
}

?>