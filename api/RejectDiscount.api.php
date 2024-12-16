<?php
require_once('../classes/account.class.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account = new Account();
    $applicationId = $_POST['application_id'] ?? null;

    if ($applicationId) {
        // Add method to update status to 'Rejected'
        $result = $account->updateDiscountApplicationStatus($applicationId, 'Rejected');
        // echo json_encode(['success' => 'success', 'message' => $result['message']]);
        echo json_encode($result);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Application ID is required']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}