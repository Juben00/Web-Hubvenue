<?php
require_once '../classes/account.class.php';
require_once '../classes/venue.class.php';
require_once '../sanitize.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $bookingId = clean_input($_GET['booking_id']);
    $guestId = clean_input($_SESSION['user']['id']);

    if (empty($bookingId) || empty($bookingId)) {
        $response = array(
            'status' => 'error',
            'message' => 'Failed to mark booking as attended. Please try again.'
        );
        echo json_encode($response);
        exit();
    } else {
        $venueObj = new Venue();
        $result = $venueObj->markBookingAsCheckedOut($bookingId, $guestId);

        // echo json_encode($result);
        header('Location: ../index.php');
        exit();
    }
}