<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';
require_once '../sanitize.php';

session_start();

$venue_id = $review = $rating = '';
$venue_idErr = $reviewErr = $ratingErr = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = $_SESSION['user']['id'];
    $venueId = clean_input($_POST['venueId']);
    $rating = clean_input($_POST['ratings']);
    $review = clean_input($_POST['review-text']);

    if (empty($venueId)) {
        $venue_idErr = 'Venue ID is required';
    }
    if (empty($rating)) {
        $ratingErr = 'Rating is required';
    }
    if (empty($review)) {
        $reviewErr = 'Review is required';
    }

    if (empty($venue_idErr) && empty($ratingErr) && empty($reviewErr)) {
        $accountObj = new Account();
        $accountObj->giveReview($userId, $venueId, $review, $rating);

        echo json_encode(['status' => 'success', 'message' => 'Review added successfully.']);
    } else {

        echo json_encode(['status' => 'error', 'message' => 'Failed to give reviews.']);
    }


} else {
    echo json_encode(['status' => 'error', 'message' => implode('<br>', [$venue_idErr, $ratingErr, $reviewErr])]);
}
?>