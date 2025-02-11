<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';
require_once '../sanitize.php';

session_start();

$venue_id = $review = $rating = $userId = '';
$venue_idErr = $reviewErr = $ratingErr = $userIdErr = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = $_SESSION['user'];
    $venueId = clean_input($_POST['venueId']);
    $rating = clean_input($_POST['ratings']);
    $review = clean_input($_POST['review-text']);

    if (empty($userId)) {
        $userIdErr = 'Please login to give review';
    }
    if (empty($venueId)) {
        $venue_idErr = 'Venue ID is required';
    }
    if (empty($rating)) {
        $ratingErr = 'Rating is required';
    }
    if (empty($review)) {
        $reviewErr = 'Review is required';
    }

    if (empty($userId) && empty($venue_idErr) && empty($ratingErr) && empty($reviewErr)) {
        $accountObj = new Account();
        $result = $accountObj->giveReview($userId, $venueId, $review, $rating);

        echo json_encode($result);
        exit();

    } else {
        echo json_encode(['status' => 'error', 'message' => implode('<br>', [$venue_idErr, $ratingErr, $reviewErr])]);
    }
}
?>