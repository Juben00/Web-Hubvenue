<?php
require_once '../classes/account.class.php';
require_once '../sanitize.php';

$accountObj = new Account();

$userId = $venueId = "";
$userIdErr = $venueIdErr = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $userId = clean_input($_POST['userId']);
    $venueId = clean_input($_POST['venueId']);

    if (empty($userId)) {
        $userIdErr = "You need to login for you to be able to bookmark.";
    }
    if (empty($venueId)) {
        $venueIdErr = "Venue ID is required.";
    }

    if (empty($userIdErr) && empty($venueIdErr)) {
        $result = $accountObj->addBookmark($userId, $venueId);

        // if ($result['status'] == 'success') {
        //     echo json_encode(['status' => 'success', 'message' => $result['message'], 'action' => $result['action']]);
        // } else {
        //     echo json_encode(['status' => 'error', 'message' => $result['message']]);
        // }
        echo json_encode($result);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => implode("<br>", [$userIdErr, $venueIdErr])]);
    }

}



