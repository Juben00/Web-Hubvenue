<?php
require_once '../classes/account.class.php';
require_once '../sanitize.php';

$accountObj = new Account();

$email = $password = '';
$emailErr = $passwordErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = clean_input($_POST['email']);
    $password = clean_input($_POST['password']);

    if (empty($email)) {
        $emailErr = 'Email is required';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = 'Invalid email format';
    }

    if (empty($password)) {
        $passwordErr = 'Password is required';
    } else if (strlen($password) < 8) {
        $passwordErr = 'Password must be at least 8 characters';
    }

    if (empty($emailErr) && empty($passwordErr)) {
        $accountObj->email = $email;
        $accountObj->password = $password;

        $result = $accountObj->login();



        echo json_encode($result);


    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    }
}