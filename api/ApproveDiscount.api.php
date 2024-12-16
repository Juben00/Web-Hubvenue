<?php
require_once('../classes/account.class.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account = new Account();
    $applicationId = $_POST['application_id'] ?? null;

    if ($applicationId) {
        // Add method to update status to 'Approved'
        $result = $account->updateDiscountApplicationStatus($applicationId, 'Approved');
        echo json_encode($result);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Application ID is required']);
    }
}