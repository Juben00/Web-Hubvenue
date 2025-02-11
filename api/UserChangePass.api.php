<?php

require_once '../classes/account.class.php';
require_once '../sanitize.php';

session_start();

$accountObj = new Account();

$userId = $currentPass = $newPass = $confirmPass = "";
$userIdErr = $currentPassErr = $newPassErr = $confirmPassErr = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user'];
    $currentPass = clean_input($_POST['current_password']);
    $newPass = clean_input($_POST['new_password']);
    $confirmPass = clean_input($_POST['confirm_password']);

    if (empty($userId)) {
        $userIdErr = "User ID is required";
    }
    if (empty($currentPass)) {
        $currentPassErr = "Current password is required";
    }
    if (empty($newPass)) {
        $newPassErr = "New password is required";
    } elseif (strlen($newPass) < 8) {
        $newPassErr = "Password must be at least 8 characters";
    } elseif (!preg_match("#[0-9]+#", $newPass)) {
        $newPassErr = "Password must contain at least one number";
    } elseif (!preg_match("#[A-Z]+#", $newPass)) {
        $newPassErr = "Password must contain at least one uppercase letter";
    } elseif (!preg_match("#[a-z]+#", $newPass)) {
        $newPassErr = "Password must contain at least one lowercase letter";
    }

    if (empty($confirmPass)) {
        $confirmPassErr = "Confirm password is required";
    } elseif ($newPass !== $confirmPass) {
        $confirmPassErr = "Passwords do not match";
    }

    if (empty($userIdErr) && empty($currentPassErr) && empty($newPassErr) && empty($confirmPassErr)) {
        $result = $accountObj->updateUserPassword($userId, $currentPass, $newPass, $confirmPass);
        // if ($result['status'] === 'success') {
        //     echo json_encode(['status' => 'success', 'message' => $result['message']]);
        // } else {
        //     echo json_encode(['status' => 'error', 'message' => $result['message']]);
        // }
        echo json_encode($result);
        exit();
    } else {
        // Return the errors as a comma-separated message
        echo json_encode([
            'status' => 'error',
            'message' => implode('<br>', array_filter([
                $userIdErr,
                $currentPassErr,
                $newPassErr,
                $confirmPassErr
            ]))
        ]);

    }
}
?>