<?php
header('Content-Type: application/json');
require_once '../classes/account.class.php';

try {
    if (!isset($_GET['host_id'])) {
        throw new Exception('Host ID is required');
    }

    $accountObj = new Account();
    $owner = $accountObj->getUser($_GET['host_id']);

    if ($owner) {
        echo json_encode([
            'success' => true,
            'owner' => $owner
        ]);
    } else {
        throw new Exception('Owner not found');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 