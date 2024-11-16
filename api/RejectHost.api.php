<?php
require_once '../classes/account.class.php';
require_once '../sanitize.php';

$accountObj = new Account();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host_id = clean_input($_POST['host_id'] ?? '');

    if (empty($host_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Host ID is required']);
        exit;
    }

    $result = $accountObj->rejectHost($host_id);
    echo json_encode($result);
    exit;
}