<?php
session_start();
require_once '../classes/account.class.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$accountObj = new Account();

try {
    $data = [
        'id' => $_SESSION['user']['id'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone']
    ];

    if ($accountObj->updateUser($data)) {
        // Update session data
        $_SESSION['user']['firstname'] = $_POST['firstname'];
        $_SESSION['user']['lastname'] = $_POST['lastname'];
        $_SESSION['user']['email'] = $_POST['email'];
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update account']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 