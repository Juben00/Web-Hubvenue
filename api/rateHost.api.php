<?php
require_once '../classes/account.class.php';
require_once '../classes/venue.class.php';
require_once '../sanitize.php';


$accountObj = new Account();
$venueObj = new Venue();

$user_id = $host_id = $rating = $review = "";
$user_idErr = $host_idErr = $ratingErr = $reviewErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = clean_input($_POST['user_id']);
    $host_id = clean_input($_POST['host_id']);
    $rating = clean_input($_POST['ratings']);
    $review = clean_input($_POST['review-text']);

    if (empty($user_id)) {
        $user_idErr = "Please login to give review";
    }
    if (empty($host_id)) {
        $host_idErr = "Host ID is required";
    }
    if (empty($rating)) {
        $ratingErr = "Rating is required";
    }
    if (empty($review)) {
        $reviewErr = "Review is required";
    }

    if (empty($user_idErr) && empty($host_idErr) && empty($ratingErr) && empty($reviewErr)) {
        $result = $venueObj->rateHost($user_id, $host_id, $rating, $review);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Host rated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'An error occurred while rating host']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => implode('<br>', [$user_idErr, $host_idErr, $reviewErr, $ratingErr])]);
    }
}

